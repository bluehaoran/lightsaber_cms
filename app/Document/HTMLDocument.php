<?php namespace App\Document;

use App\DB\Document as DocumentModel;

/**
 * In comes HTML, out goes HTML.
 */
class HTMLDocument {
	
	/**
	 * Take in input, create a Document
	 * @param type $format 
	 * @return DocumentModel
	 */
	static function consume($format) {

            // $table->string('type');
            // $table->string('title')->index();
            // $table->json('data');
            // $table->text('html')->index();


		// return ;
	}

	/**
	 * Produce HTML.
	 * @return String HTML
	 */
	function render() {
		return $this->document->html;
	}



}