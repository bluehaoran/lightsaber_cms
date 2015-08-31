<?php namespace App\DB;

use Illuminate\Database\Eloquent\Model;

/**
 * Model
 * @package default
 */
class Document extends Model
{
    
    /**
     * Factory function for the appropriate Document Handler
     * @return type
     */
	public function factory() {

		switch ($this->type) {

			case 'html':
				# code...
				return new HTMLDocument(this);
				break;

			case 'markdown':
				return new MarkdownDocument(this);
				break;

			case 'pdf':
				return new PDFDocument(this);
				break;

		}

	}

}
