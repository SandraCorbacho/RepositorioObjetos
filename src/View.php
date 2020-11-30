<?php
namespace App;
interface View{
    public function render(?array $dataView = null, ?string $template = null);
    //public function json();
}