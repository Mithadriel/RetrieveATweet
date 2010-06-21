<?php
	class tweet {
		var $screen_name;		
			function __construct($screen_name) {
				if (!$screen_name) {
					exit("You have failed to provide a screen name!");
				}
				$this->screen_name = $screen_name;
				return $this->screen_name;
			}
			
			public function BuildUrl() {
				$this->url = "http://api.twitter.com/1/statuses/user_timeline.xml?screen_name=" . $this->screen_name;
				return $this->url; 
			}
			
			public function RetrieveUrl() {
				$url = $this->BuildUrl();
				$retrieved = file_get_contents($url);
				$this->parsed = simplexml_load_string($retrieved);
				return $this->parsed;
			}
			
			// function borrowed from http://uk2.php.net/manual/en/book.simplexml.php#97555
			public function objectsIntoArray($arrObjData, $arrSkipIndices = array())
			{
			    $arrData = array();
			    // if input is object, convert into array
			    if (is_object($arrObjData)) {
			        $arrObjData = get_object_vars($arrObjData);
			    }
			    if (is_array($arrObjData)) {
			        foreach ($arrObjData as $index => $value) {
			            if (is_object($value) || is_array($value)) {
			                $value = $this->objectsIntoArray($value, $arrSkipIndices); // recursive call
			            }
			            if (in_array($index, $arrSkipIndices)) {
			                continue;
			            }
			            $arrData[$index] = $value;
			        }
			    }
			    return $arrData;
			}
			
			public function ReturnTweet() {
				$parsed = $this->RetrieveUrl();
				$tweets = $this->objectsIntoArray($parsed);
				$this->tweet = $tweets[status][0];
				$this->text = $this->tweet[text];
				return $this->text;
			}
	}
?>