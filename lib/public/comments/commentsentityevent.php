<?php
/**
 * @author Joas Schilling <nickvergessen@owncloud.com>
 *
 * @copyright Copyright (c) 2016, ownCloud, Inc.
 * @license AGPL-3.0
 *
 * This code is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License, version 3,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License, version 3,
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 */

namespace OCP\Comments;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class CommentsEvent
 *
 * @package OCP\Comments
 * @since 9.0.0
 */
class CommentsEntityEvent extends Event {

	const EVENT_ENTITY = 'OCP\Comments\ICommentsManager::registerEntity';

	/** @var string */
	protected $event;
	/** @var \Closure[] */
	protected $collections;

	/**
	 * DispatcherEvent constructor.
	 *
	 * @param string $event
	 * @since 9.0.0
	 */
	public function __construct($event) {
		$this->event = $event;
		$this->collections = [];
	}

	/**
	 * @param string $name
	 * @param \Closure $entityExistsFunction
	 * @throws \OutOfBoundsException when the entity name is already taken
	 * @since 9.0.0
	 */
	public function addEntityCollection($name, \Closure $entityExistsFunction) {
		if (isset($this->collections[$name])) {
			throw new \OutOfBoundsException('Duplicate entity name "' . $name . '"');
		}

		$this->collections[$name] = $entityExistsFunction;
	}

	/**
	 * @return \Closure[]
	 * @since 9.0.0
	 */
	public function getEntityCollections() {
		return $this->collections;
	}
}
