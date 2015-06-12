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
interface PostRepositoryInterface
{
  /**
   * Finds a single post by its id and returns it.
   *
   * If no post is found a value of <tt>null</tt> will be returned.
   *
   * @param int $id
   * @return \Rhapsody\ForumBundle\Model\PostInterface the matching post or
   *    <tt>null</tt>.
   */
  function findById($id);

  /**
   * Finds all posts matching the specified Topic ordered by their
   * last created date
   *
   * @param TopicInterfacd $topic
   * @return array|Paginator
   */
  function findAllByTopic($topic);

  /**
   * Finds more recent posts matching the specified Topic
   *
   * @param Topic $topic
   * @param int $number max number of posts to fetch
   * @return array of Post
   */
  function findRecentByTopic($topic, $number);

  /**
   * Finds all posts matching the specified query ordered by their
   * last created date
   *
   * @param string $query
   * @return array|Paginator
   */
  function search($query);

  /**
   * Gets the post that preceds this one
   *
   * @return Post or null
   **/
  public function getPostBefore($post);

  /**
   * Creates a new post instance
   *
   * @return Post
   */
  function createNewPost();
}
