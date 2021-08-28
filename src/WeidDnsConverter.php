<?php



class WeidDnsConverter
{
	public static function host2dns(string $host):array {
	  return array_reverse(explode('.', $host));	
	}
	
	public static function dns2host(array $dns):string {
	   return implode('.', array_reverse($dns));	
	}
	
  	public static function weid2host($weid, $namespace='weid:', $base='9-DNS-7'):string {
        
        $p=explode(':', $weid, 2);
		if($namespace === $p[0] && count($p)===2){
			 $weid=$p[1];
		}
		 

		$elements = explode('-', $weid);
		$actual_checksum = array_pop($elements);
		$expected_checksum = \WeidHelper::weLuhnGetCheckDigit(implode('-',$elements));
		if ($actual_checksum !== '?') {
			if (!is_numeric($actual_checksum) || intval($actual_checksum) !== $expected_checksum) return false; // wrong checksum
		} else {
			// If checksum is '?', it will be replaced by the actual checksum,
			// e.g. weid:EXAMPLE-? becomes weid:EXAMPLE-3
			$weid = str_replace('?', $expected_checksum, $weid);
		}
		foreach ($elements as &$arc) {
			 
		//	$arc = strtoupper(self::base_convert_bigint($arc, 36, 10));
                   $arc = strtolower($arc);
		}
		
		for($i=0;$i<count(explode('-', $base))-1;$i++){
			array_shift($elements);
		}
		$host = implode('.', array_reverse($elements));

		return $host;
	}

	public static function host2weid($host, $namespace='weid', $base='9-DNS-7'):string {
		$elements = array_reverse(explode('.', $host));
		foreach ($elements as &$arc) {
		//			$arc = strtoupper(self::base_convert_bigint($arc, 10, 36));
                	$arc = strtoupper($arc);
		}
		$weidstr =substr($base,0,strlen($base)-2).'-'. implode('-', $elements);		 

		return trim($namespace . ':'.$weidstr
			    . '-'.\WeidHelper::weLuhnGetCheckDigit($weidstr), ': ');
	}
  
}
