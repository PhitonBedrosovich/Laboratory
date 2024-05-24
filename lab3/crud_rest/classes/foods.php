<?php
require_once "tableModule.php";

class Foods extends TableModule
{
	protected function getTableName(): string
	{
		return "menu";
	}
}