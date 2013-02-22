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
namespace Rhapsody\ForumBundle\Model;

/**
 *
 * @author 	  Sean W. Quinn
 * @category  Rhapsody ForumBundle
 * @package   Rhapsody\ForumBundle\Model
 * @copyright Copyright (c) 2013 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class Topic
{

	/**
	 * The identifier for this topic.
	 * @property mixed
	 * @access protected
	 */
	protected $id;
	
	/**
	 * The date when this topic was last updated. New posts, and edits to
	 * existing posts should update this value.
	 * @property int
	 * @access protected
	 */
	protected $lastUpdated;
	
	/**
	 * The forum that this topic is located in.
	 * @property Forum
	 * @access protected
	 */
	protected $forum;
	
	/**
	 * If the topic is locked.
	 * @property boolean
	 * @access protected
	 */
	protected $locked;
	
	/**
	 * The type of the topic; e.g. normal, sticky, announcement, and global.
	 * If the topic has been marked as "sticky" it will show up before all
	 * normal posts, announcements precede sticky topics, and global topics
	 * preced all others and are visible on all forums.
	 * @property boolean 
	 * @access protected
	 */
	protected $type;
	
	/**
	 * The number of days to promote a topic at a higher visibility type. If
	 * greater than <tt>zero</tt>, and a type other than <tt>normal</tt> is
	 * selected than this topic will remain at the selected type for the
	 * indicated number of days before reverting back to a <tt>normal</tt> topic
	 * type.
	 * @property int
	 * @access protected
	 */
	protected $promotionDays;
	
	/**
	 * The poll associated with this topic, <tt>null</tt> if there is no poll.
	 * @property Poll
	 * @access protected
	 */
	protected $poll;
	
	/**
	 * The posts associated with this topic.
	 */
	protected $posts;
}