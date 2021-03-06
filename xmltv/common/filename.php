<?php


namespace datagutten\xmltv\tools\common;


use datagutten\tools\files\files as file_tools;

class filename
{
    /**
     * Generate folder path
     * @param string $channel XMLTV channel id to use as base folder name
     * @param string $sub_folder Sub folder of the channel folder
     * @param int $timestamp Timestamp to get year
     * @return string Folder path
     */
    public static function folder(string $channel, string $sub_folder, int $timestamp)
    {
        return file_tools::path_join($channel, $sub_folder, date('Y',$timestamp));
    }

    /**
     * Generate file name
     * @param string $channel XMLTV channel
     * @param int $timestamp Timestamp to get date
     * @param string $extension File extension
     * @return string File name
     */
    public static function filename(string $channel, int $timestamp, string $extension)
    {
        return $channel.'_'.date('Y-m-d',$timestamp).'.'.$extension;
    }

    /**
     * Generate file and folder path
     * @param string $channel XMLTV channel
     * @param string $sub_folder Sub folder of the channel folder
     * @param int $timestamp Timestamp to get date
     * @param string $extension File extension
     * @return string File name
     */
    public static function file_path(string $channel, string $sub_folder, int $timestamp, string $extension)
    {
        $folder = self::folder($channel,$sub_folder,$timestamp);
        $file = self::filename($channel,$timestamp,$extension);
        return $folder.'/'.$file;
    }
}