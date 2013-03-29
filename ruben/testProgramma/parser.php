<?php
	require_once 'prog.php';
	
    class Parser{
    	private $sql = array('host' => "localhost", 'name' => 'c7070chi_wordpress', 
    	'username' => "c7070chi_prog", 'password' => 'chrsell882', 'table' => "wp_programma");
		
		public function getProgrammaByAfdeling($afdeling){
				$afdelingen = $this->getAfdelingen($afdeling);
				if($afdelingen == FALSE){
					return false;
				}
				$this->connect();
				$qry = "SELECT `datum`, `afdeling`, `programma` FROM `" . $this->sql["table"] . "` WHERE (";
				$first = true;
				foreach ($afdelingen as $af) {
					if(!$first){
						$qry .= " or ";
					}
					$first = false;
					$qry .= "`afdeling`=" . $af;
				}
				$qry .= ") AND `datum`>=CURRENT_DATE() ORDER BY  `wp_programma`.`datum` ASC LIMIT 0 , 50";
				$result = mysql_query($qry);
				return $this->parse($result);
				
		} 
		public function getProgrammaByStartDate($afdeling, $date){
			$afdelingen = $this->getAfdelingen($afdeling);
			if($afdelingen == FALSE){
				return FALSE;
			}
			$this->connect();
			$qry = "SELECT `datum`, `afdeling`, `programma` FROM `" . $this->sql["table"] . "' WHERE (";
			$first = true;
			foreach ($afdelingen as $af) {
				if(!$first){
					$qry .= " or ";
				}
				$first = false;
				$qry .= "`afdeling`=" . $af;
			}
			$qry .= ") AND `datum`>=" . $date . " ORDER BY  `wp_programma`.`datum` ASC";
			$result = mysql_query($qry);
			return $this->parse($result);
		}
		public function getProgrammaBetweenDate($afdeling, $startDate, $endDate){
			$afdelingen = $this->getAfdelingen($afdeling);
			if($afdelingen == FALSE){
				return FALSE;
			}
			$this->connect();
			$qry = "SELECT `datum`, `afdeling`, `programma` FROM `" . $this->sql["table"] . "' WHERE (";
			$first = true;
			foreach ($afdelingen as $af) {
				if(!$first){
					$qry .= " or ";
				}
				$first = false;
				$qry .= "`afdeling`=" . $af;
			}
			$qry .= ") AND `datum`>=" . $startDate . " AND `datum`<" . $endDate .  " ORDER BY  `wp_programma`.`datum` ASC";
			return $this->parse($result);
		}
		
		private function connect(){
			if(!mysql_connect($this->sql['host'], $this->sql['username'], $this->sql['password'])) throw new Exception("Kan geen verbinding maken met DB");
			if(!mysql_select_db($this->sql['name'])) throw new Exception("Kan geen verbinding maken met database");
		}
		
		private function parse($result){
			$toReturn = array();
			while($row = mysql_fetch_array($result)){
				$temp = new Prog;
				$temp->inisialize($row["datum"], $row["afdeling"], iconv('UTF-8', 'windows-1252', str_replace("\\", "", $row["programma"])));
				$toReturn[] = $temp;
			}
			return $toReturn;
		}
		
		static private function getAfdelingen($afdeling){
			$result = array();
			if($afdeling <= 0 or $afdeling > 22){
				return false;
			}
			$result[] = $afdeling;
			if($afdeling <= 12){
				$result[] = 13;
				$result[] = 17;
			}
			if($afdeling <= 4){
				$result[] = 21;
			}else if($afdeling <= 6){
				$result[] = 22;
			}else if($afdeling <= 12){
				$result[] = 16;
			}
			return $result;
		}
		
    }
?>