<?php
require_once "tableModule.php";

class Menus extends TableModule
{
	protected function getTableName(): string
	{
		return "dishes";
	}
}