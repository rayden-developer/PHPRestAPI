<?php
namespace Core;

interface iAPI{
   public function GET($args);
   public function POST($args);
   public function PUT($args);
   public function DELETE($args);
}