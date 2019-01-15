<?php

class DB_Connect {
	protected $db;
	protected function __construct( $dbo = NULL ){
		try
		{
			$this->db = $dbo;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}
}