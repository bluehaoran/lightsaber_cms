<?php namespace App\Document;

use App\DB\Document as DocumentModel;

/**
 * This represents a document that can be created in the CMS.
 * 
 * It can be treated like an Eloquent model to write to the DB, but 
 * confusingly enough, it works by encapsulation rather than inheritance.
 * 
 */
abstract class AbstractDocument {
	
	public DocumentModel $document;

	public function __construct(DocumentModel $document) {
		$this->document = $document;
	}

	/**
	 * Magic function so that everything else can pretend that an Abstract Document
	 * does Document-like stuff. 
	 */
	public final function __call($name, $arguments) {
		$this->document->$name($arguments);
	}


	/**
	 * Take in input, create a Document
	 * @param type $format 
	 * @return DocumentModel
	 */
	abstract static function consume($format);

	/**
	 * Produce HTML.
	 * @return String HTML
	 */
	abstract function render();



}