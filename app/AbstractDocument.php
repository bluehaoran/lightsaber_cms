<?php namespace App;



/**
 * This represents a document that can be created in the CMS.
 * 
 * It can be treated like an Eloquent model to write to the DB, but 
 * confusingly enough, it works by encapsulation rather than inheritance.
 * 
 */
abstract class AbstractDocument {
	
	public Document $document;

	public function __construct(Document $document) {
		$this->document = $document;
	}


	/**
	 * Magic function so that everything else can pretend that an Abstract Document
	 * does Document-like stuff. 
	 */
	public function __call($name, $arguments) {
		$this->document->$name($arguments);
	}

}