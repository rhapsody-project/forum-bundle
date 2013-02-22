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
class Forum
{
	/* The forum is marked as a category, categories cannot have topics. */
	const FORUM_TYPE_CATEGORY = 'category';
	
	/* The forum is marked as a normal forum. */
	const FORUM_TYPE_FORUM = 'forum';

	/**
	 * The identifier for the forum.
	 * @property mixed
	 * @access protected
	 */
	protected $id;
	
	/**
	 * The name of the forum.
	 * @property string
	 * @access protected
	 */
	protected $name;

	/**
	 * The type of the forum.
	 * @property string
	 * @access protected
	 */
	protected $type;
	
	/**
	 * The display order of the forum, with relation to its siblings.
	 * @property int
	 * @access protected
	 */
	protected $order;
	
	/**
	 * Forums can be embedded one-within-another.
	 * @property Forum
	 * @access protected
	 */
	protected $forum;
	
	/**
	 * The collection of topics in this forum.
	 * @property array
	 * @access protected
	 */
	protected $topics;
}
