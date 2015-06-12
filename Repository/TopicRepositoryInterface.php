<?php
/* Copyright (c) 2013 Rhapsody Project
 *
 * Licensed under the MIT License (http://opensource.org/licenses/MIT)
 *
 * Permission is hereby granted, free of charge, to any
 * person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the
 * Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software,
 * and to permit persons to whom the Software is furnished
 * to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice
 * shall be included in all copies or substantial portions of
 * the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY
 * KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 * WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR
 * PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS
 * OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR
 * OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT
 * OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
namespace Rhapsody\ForumBundle\Repository;

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody ForumBundle
 * @package   Rhapsody\ForumBundle\Repository
 * @copyright Copyright (c) 2013 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
interface TopicRepositoryInterface
{
	/**
	 * Finds a single topic by its ID.
	 *
	 * @param integer $id
	 * @return Topic or NULL whether the specified id does not match any topic
	 */
	function findById($id);

	/**
	 * Finds a single topic by its slug.
	 *
	 * @param string $slug
	 * @return Topic or NULL whether the specified id does not match any topic
	 */
	function findBySlug($id);

	/**
	 * Finds one topic by its category and its slug
	 *
	 * @param Category $category
	 * @paral string $slug
	 * @return Topic or NULL
	 **/
	function findOneByCategoryAndSlug($category, $slug);

	/**
	 * Finds one topic by its id
	 *
	 * @param integer $id
	 * @return Topic or NULL whether the specified id does not match any topic
	 */
	function findOneById($id);

	/**
	 * Finds all topics ordered by their last pull date
	 *
	 * @return array
	 */
	function findAllTopics();

	/**
	 * Finds all topics matching to the specified Category ordered by their
	 * last pull date
	 *
	 * @param integer|Category $category
	 * @return array|Paginator
	 */
	function findAllByCategory($category);

	/**
	 * Get topics which have the more recent last post
	 *
	 * @param int $number
	 * @return array of Topics
	 */
	function findLatestPosted($number);

	/**
	 * Finds all topics matching the specified query ordered by their
	 * last pulled date
	 *
	 * @param string $query
	 * @return array|Paginator
	 */
	function search($query);

	/**
	 * Increment the number of views of a topic
	 *
	 * @param Topic $topic
	 * @return void
	 */
	function incrementTopicNumViews($topic);

	/**
	 * Creates a new post instance
	 *
	 * @return Topic
	 */
	function createNewTopic();
}
