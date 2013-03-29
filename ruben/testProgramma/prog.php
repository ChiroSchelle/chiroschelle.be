<?php
   class Prog{
   		private $m_datum;
		private $m_afdeling;
		private $m_programma;
		
		function inisialize($datum, $afdeling, $programma){
			$this->m_datum = $datum;
			$this->m_afdeling = $afdeling;
			$this->m_programma = $programma;
		}
		
		function makeXML(){
			$str = '<programma datum="' . $this->m_datum . '" afdeling="' . $this->m_afdeling . "\" >";
			$str .= $this->m_programma;
			$str .= "</programma> \n";
			return $str;
		}
   }
?>