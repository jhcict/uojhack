<?php

namespace BByer\Source\Applications;


interface ApplicationRepository
{

    public function searchApplication($string, $param);
}