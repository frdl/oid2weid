<?php

class WeidDnsConverter
{
  	public static function weid2dns(&$weid, $namespace='weid:', $base='9-DNS-7') {
		if (stripos($weid, $namespace) !== 0)  return false; // wrong namespace
      
		$weid = explode(':', $weid, 2)[1]; // remove namespace

		$elements = array_merge(explode('-', $base), explode('-', $weid));
		$actual_checksum = array_pop($elements);
		$expected_checksum = self::weLuhnGetCheckDigit(implode('-',$elements));
		if ($actual_checksum !== '?') {
			if ($actual_checksum !== $expected_checksum) return false; // wrong checksum
		} else {
			// If checksum is '?', it will be replaced by the actual checksum,
			// e.g. weid:EXAMPLE-? becomes weid:EXAMPLE-3
			$weid = str_replace('?', $expected_checksum, $weid);
		}
		foreach ($elements as &$arc) {
			 
		//	$arc = strtoupper(self::base_convert_bigint($arc, 36, 10));
        $arc = strtolower($arc);
		}
		$dnsstr = implode('.', array_reverse($elements));

		return $dnsstr;
	}

	public static function dns2weid($dns, $namespace='weid:', $base='9-DNS-7') {
		$elements = array_reverse(explode('.', $dns));
		foreach ($elements as &$arc) {
		//			$arc = strtoupper(self::base_convert_bigint($arc, 10, 36));
      	$arc = strtoupper($arc);
		}
		$weidstr = implode('-', $elements);

		if (stripos($weidstr.'-', $base.'-') !== 0) return false; // wrong base

		return $namespace . substr($weidstr.'-'.self::weLuhnGetCheckDigit($weidstr), strlen($base.'-'));
	}
  
}
