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
class Post
{

	/**
	 * The identifier for the post.
	 * @property mixed
	 * @access protected
	 */
	protected $id;

	/**
	 * The author of the post.
	 * @property mixed
	 * @access protected
	 */
	protected $author;
	
	/**
	 * The topic that this post belongs to.
	 * @property Topic
	 * @access protected
	 */
	protected $topic;
	
	/**
	 * If a this is a reply to a preceding post, <tt>$replyTo</tt> is the
	 * reference to that <tt>Post</tt>.
	 * @property Post
	 * @access protected
	 */
	protected $replyTo;

	/**
	 * The subject of this post.
	 * @property string
	 * @access protected
	 */
	protected $subject;
	
	/**
	 * The text of this post.
	 * @property string
	 * @access protected
	 */
	protected $text;
	
	/**
	 * The markup format of this post. E.g. <tt>bbcode</tt>, <tt>markdown</tt>,
	 * etc.
	 * @property string
	 * @access protected
	 */
	protected $format;

	/**
	 * The time thate this post was created.
	 * @property int
	 * @access protected
	 */
	protected $timestamp;
	
	/**
	 * The last user to edit this post.
	 * @property mixed
	 * @access protected
	 */
	protected $editor;
	
	/**
	 * The reason for editing the post.
	 * @property string
	 * @access protected
	 */
	protected $reason;
	
	/**
	 * The timestamp of the edit, or equal to the <tt>$timestamp</tt> if the 
	 * post has never been edited.
	 * @property int
	 * @access protected
	 */
	protected $lastUpdated;
	
	/**
	 * The files that have been attached to this post.
	 * @property
	 */
	protected $attachments;
	
	public function getAttachments()
	{
		return $this->attachements;
	}
	
	/**
	 * <p>
	 * Returns the <tt>$author</tt> of this post.
	 * </p>
	 *
	 * @return IForumUser the forum user who authored this post.
	 */
	public function getAuthor()
	{
		return $this->author;
	}
	
	public function getLastUpdated()
	{
		return $this->lastUpdated;
	}
}