<?php
class Categories extends OssnObject {
		/**
		 * Add category
		 * 
		 * @param string $title A category title
		 * @param string $description A description of website
		 *
		 * @return boolean
		 */
		public function addCategory($title = '', $description = '') {
				if(!empty($title)) {
						$this->title       = $title;
						$this->description = $description;
						$this->owner_guid  = 1;
						$this->type        = 'site';
						$this->subtype     = 'user:category';
						
						if(!ctype_alpha($title)) {
								return false;
						}
						if($this->addObject()) {
								return true;
						}
						
				}
				return false;
		}
		/**
		 * Get all categories
		 * 
		 * @param null
		 *
		 * @return array
		 */
		public function getAll() {
				return $this->searchObject(array(
						'type' => 'site',
						'subtype' => 'user:category',
						'page_limit' => false
				));
		}
		/**
		 * Prepare category field name
		 * 
		 * @param string $title A category title
		 *
		 * @return string|boolean
		 */
		public static function prepare($title) {
				if(!empty($title)) {
						return strtolower($title);
				}
				return false;
		}
}