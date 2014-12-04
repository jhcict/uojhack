<?php namespace BByer\System\Passwords;

use Carbon\Carbon;
use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;

class MongoTokenRepository implements TokenRepositoryInterface
{

    protected $connection;

    protected $collection;

    protected $hashKey;

    protected $expires;

    public function __construct(DatabaseManager $connection, $table, $hashKey, $expires = 60)
    {
        $this->table = $table;
        $this->hashKey = $hashKey;
        $this->expires = $expires * 60;
        $this->connection = $connection;
    }

    /**
     * Create a new token record.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword $user
     *
     * @return string
     */
    public function create(CanResetPasswordContract $user)
    {
        $email = $user->getEmailForPasswordReset();

        $this->deleteExisting($user);

        // We will create a new, random token for the user so that we can e-mail them
        // a safe link to the password reset form. Then we will insert a record in
        // the database so that we can verify the token within the actual reset.
        $token = $this->createNewToken($user);

        $this->getCollection()->insert($this->getPayload($email, $token));

        return $token;
    }

    /**
     * Delete all existing reset tokens from the database.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword $user
     *
     * @return int
     */
    protected function deleteExisting(CanResetPasswordContract $user)
    {
        return $this->getCollection()->where('email', $user->getEmailForPasswordReset())->delete();
    }

    /**
     * Build the record payload for the table.
     *
     * @param  string $email
     * @param  string $token
     *
     * @return array
     */
    protected function getPayload($email, $token)
    {
        return ['email' => $email, 'token' => $token, 'created_at' => new Carbon];
    }

    /**
     * Determine if a token record exists and is valid.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword $user
     * @param  string                                      $token
     *
     * @return bool
     */
    public function exists(CanResetPasswordContract $user, $token)
    {
        $email = $user->getEmailForPasswordReset();

        $token = (array) $this->getCollection()->where('email', $email)->where('token', $token)->first();

        return $token && ! $this->tokenExpired($token);
    }

    /**
     * Determine if the token has expired.
     *
     * @param  array $token
     *
     * @return bool
     */
    protected function tokenExpired($token)
    {
        $createdPlusHour = strtotime($token['created_at']) + $this->expires;

        return $createdPlusHour < $this->getCurrentTime();
    }

    /**
     * Get the current UNIX timestamp.
     *
     * @return int
     */
    protected function getCurrentTime()
    {
        return time();
    }

    /**
     * Delete a token record by token.
     *
     * @param  string $token
     *
     * @return void
     */
    public function delete($token)
    {
        $this->getCollection()->where('token', $token)->delete();
    }

    /**
     * Delete expired tokens.
     *
     * @return void
     */
    public function deleteExpired()
    {
        $expired = Carbon::now()->subSeconds($this->expires);

        $this->getCollection()->where('created_at', '<', $expired)->delete();
    }

    /**
     * Create a new token for the user.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword $user
     *
     * @return string
     */
    public function createNewToken(CanResetPasswordContract $user)
    {
        $email = $user->getEmailForPasswordReset();

        $value = str_shuffle(sha1($email . spl_object_hash($this) . microtime(true)));

        return hash_hmac('sha1', $value, $this->hashKey);
    }

    /**
     * Begin a new database query against the table.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function getCollection()
    {
        return $this->connection->collection($this->table);
    }

    /**
     * Get the database connection instance.
     *
     * @return \Illuminate\Database\Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

}
