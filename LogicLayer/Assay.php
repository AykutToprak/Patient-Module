<?php
    class Assay{
        private $tc;
		private $assayNumber;
        
        function __construct($tc = NULL, $assayNumber = NULL) {
			$this->tc            = $tc;
			$this->assayNumber   = $assayNumber;
        }
        
        public function getTc() {
			return $this->tc;
		}
		
		public function getAssayNumber() {
			return $this->assayNumber;
		}
    }
?>