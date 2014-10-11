<?php
/**
*	A simple data model class for kancolle ship girl("艦娘")
*/
class Kan {
	private $db;
	private $id = -1;
	public function __construct() {
		$this->db = Flight::db();
	}
	private $name = '';
	private function getID() {
		if ($this->id <0) {
			$name = empty($this->name) ? 'XXX' : htmlspecialchars($this->name);
			$sth = $this->db->prepare("SELECT ship_id FROM kancolle_ship_info WHERE ship_name=:name OR ship_name_sim=:name");
			$sth->bindParam(':name', $name, PDO::PARAM_STR,10);
			$sth->execute();
			$result = $sth->fetchAll(PDO::FETCH_ASSOC);
			$this->id = $result[0]['ship_id'];
		}
		return $this->id;
	}
	
	public function getRecipes($id) {
		$sth = $this->db->prepare("SELECT item1,item2,item3,item4, count(*) AS num FROM kancolle_createship_log WHERE created_ship_id=:id AND large_flag=0 GROUP BY item1,item2,item3,item4 ORDER BY num DESC");
		$sth->bindParam(':id',$id, PDO::PARAM_INT);
		$sth->execute();
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	public function getAllKan() {
		$db = Flight::db();
		$sth = $db->prepare("SELECT * FROM kancolle_ship_info");
		$sth->execute();
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	public function getKanNames() {
		$db = Flight::db();
		$sth = $db->prepare("SELECT ship_id,ship_name,ship_name_sim FROM kancolle_ship_info");
		$sth->execute();
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		$r = Array();
		foreach ($result as $kan) {
			if (strpos($kan['ship_name_sim'],'改') === false)
				array_push($r,$kan);
		}
		return $r;
	}


	public function getProfile() {
		$db = Flight::db();
		$sth = $db->prepare("SELECT count(*) FROM kancolle_createship_log");
		$sth->execute();
		$total = $sth->fetchAll(PDO::FETCH_ASSOC);

		$sth = $db->prepare("SELECT count(*) FROM kancolle_createship_log WHERE large_flag = 1");
		$sth->execute();
		$large = $sth->fetchAll(PDO::FETCH_ASSOC);

		$sth = $db->prepare("SELECT count(*) FROM kancolle_createitem_log");
		$sth->execute();
		$item = $sth->fetchAll(PDO::FETCH_ASSOC);

		$sth = $db->prepare("SELECT create_time FROM kancolle_createship_log ORDER BY create_time DESC LIMIT 0,1");
		$sth->execute();
		$timestamp = $sth->fetchAll(PDO::FETCH_ASSOC);
		$count = Array('total' => $total[0]['count(*)'], 'large' => $large[0]['count(*)'],
			'item' => $item[0]['count(*)'],'timestamp' => $timestamp[0]['create_time']);
		return $count;
	}

	public function setName($name) {
		$this->name = $name;
	}

}
