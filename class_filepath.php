<?Php
//A class to find and create xmltv file names
class filepath
{
	public $outpath;
	public function __construct($outpath)
	{
		if(substr($outpath,-1,1)!='/')
			$outpath.='/';
		$this->outpath=$outpath;
	}
	public function foldername($channel,$subfolder,$timestamp=false)
	{
		if($timestamp===false)
			$timestamp=strtotime('midnight');
		$date=date('Y',$timestamp);
		$folder=$this->outpath."$channel/$subfolder/$date/";
		if(!file_exists($folder))
			mkdir($folder,0777,true);
		return $folder;
	}
	public function filename($channel,$timestamp,$extension)
	{
		return $channel.'_'.date('Y-m-d',$timestamp).'.'.$extension;
	}
	public function fullpath($channel,$subfolder,$timestamp,$extension)
	{
		return $this->foldername($channel,$subfolder,$timestamp).$this->filename($channel,$timestamp,$extension);	
	}
}
?>