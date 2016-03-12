<?php
//Class de recherche dans la base de données
require_once("../bd/bddClass.php");
class Search extends Bdd {
	private $sql_keyword ="	SELECT p.type AS Type, p.desc AS Description, m.nom AS Medidien, m.element AS Element
					FROM patho p
					JOIN meridien m ON p.mer = m.code
					JOIN symptPatho sp ON p.idP = sp.idP
					JOIN symptome s ON s.idS = sp.idS
					JOIN keySympt ks ON ks.idS = s.idS
					JOIN keywords k ON k.idK = ks.idK
					WHERE name =?";
	private $sql_filter ="	SELECT p.type AS Type, p.desc AS Description, m.nom AS Medidien, m.element AS Element 
							FROM patho p 
							JOIN meridien m ON p.mer = m.code 
							WHERE p.desc LIKE %?% AND p.desc LIKE %?% AND p.desc LIKE %?%";


	public function __construct($post){
		parent::__construct();
		$status=self::checkdata($post);
		if ($status != 1) {
			self::toSpeak(array('status' => $status));
		}
		else {
			// sinon
			switch ($post["action"]) {
				case "keyword";
					self::searchKeyword($post);
					break;
				case "filter";
					self::searchFilter($post);
					break;
			}
		}
	}
	private function searchKeyword($post){
		$stmt=parent::executeQuerry($this->sql_keyword,array($post["keyword"]));
		
		self::toSpeak(array('status' => $stmt->rowcount()));
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			self::toSpeak($row);
		}
	}

	private function searchFilter($post){
		$stmt=parent::executeQuerry($this->sql_filter,array($post["champ1"],$post["champ2"],$post["champ3"]));

		self::toSpeak(array('status' => $stmt->rowcount()));
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			self::toSpeak($row);
		}
	}
	private function toSpeak($data){
		echo json_encode($data);
	}
	private function checkData($data){
		$status=1;èèè
	    if (isset($data["keyword"]) && !(preg_match('/^\w{2,64}$/',$data["keyword"])))		{$status="keyword mismatch";}
	    if (isset($data["champ1"]) && !(preg_match('/^\w{2,64}$/',$data["champ1"])))		{$status="champ1 mismatch";}
	    if (isset($data["champ2"]) && !(preg_match('/^\w{2,64}$/',$data["champ2"])))		{$status="champ2 mismatch";}  
	    if (isset($data["champ3"]) && !(preg_match('/^\w{2,64}$/',$data["champ3"])))		{$status="champ3 mismatch";}
		return $status;
	}
}

new Search($_POST);

?>

