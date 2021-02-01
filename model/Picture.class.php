<?php

class Picture {

	//Attribute:
    private $filename;
    private $filedatetime;
    private $uploaddate;
    private $filesize;
    private $filetype;
    private $mimetype;
    private $picsize;
    private $owner;

	//Konstruktor:
    function __construct($filename, $filedatetime, $uploaddate, $filesize, $filetype, $mimetype, $picsize, $owner) {

        $this->filename = $filename;
        $this->filedatetime = $filedatetime;
        $this->uploaddate = $uploaddate;
        $this->filesize = $filesize;
        $this->filetype = $filetype;
        $this->picsize = $picsize;
        $this->owner = $owner;
    }

	//Getter und Setter:
    public function getFilename() {
        return $this->filename;
    }

    public function getUploaddate() {
        return $this->uploaddate;
    }

    public function getFiledatetime() {
        return $this->filedatetime;
    }

    public function getFilesize() {
        return $this->filesize;
    }

    public function getFiletype() {
        return $this->filetype;
    }

    public function getOwner() {
        return $this->owner;
    }

    public function setPicsize($picsize) {
        $this->picsize = $picsize;
    }

    public function getPicsize() {
        return $this->picsize;
    }

    public function setFilename($filename) {
        $this->filename = $filename;
    }

    public function setUploaddate($uploaddate) {
        $this->uploaddate = $uploaddate;
    }

    public function setFiledatetime($filedatetime) {
        $this->filedatetime = $filedatetime;
    }

    public function setFilesize($filesize) {
        $this->filesize = $filesize;
    }

    public function setFiletype($filetype) {
        $this->filetype = $filetype;
    }

    public function setOwner($owner) {
        $this->owner = $owner;
    }

}

?>
