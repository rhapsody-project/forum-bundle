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

use Doctrine\ODM\MongoDB\Mapping\Annotations\Int;
/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody ForumBundle
 * @package   Rhapsody\ForumBundle\Model
 * @copyright Copyright (c) 2013 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class Topic implements ForumAwareInterface, TopicInterface
{

	/**
	 * The identifier for this topic.
	 * @var mixed
	 * @access protected
	 */
	protected $id;

	/**
	 * Whether the topic is approved or not. When a topic is newly created it
	 * will be approved by default, unless the forum is configured to require
	 * moderator approval for all new topics.
	 * @var boolean
	 * @access protected
	 */
	protected $approved;

	/**
	 * The category this topic is associated with, may be <tt>null</tt>. A topic
	 * with an empty category is considered to be uncategorized.
	 * @var \Rhapsody\ForumBundle\Model\CategoryInterface
	 * @access protected
	 */
	protected $category;

	/**
	 * The date when this topic was created.
	 * @var \DateTime
	 * @access protected
	 */
	protected $created;

	/**
	 * Required. The forum that this topic is in.
	 * @var \Rhapsody\ForumBundle\Model\ForumInterface
	 * @access protected
	 */
	protected $forum;

	/**
	 * The last post in the topic's thread.
	 * @var unknown
	 */
	protected $lastPost;

	/**
	 * The date when this topic was last updated. New posts, and edits to
	 * existing posts should update this value.
	 * @var \DateTime
	 * @access protected
	 */
	protected $lastUpdated;

	/**
	 * The date when this topic was last viewed.
	 * @var \DateTime
	 * @access protected
	 */
	protected $lastViewed;

	/**
	 * Whether a topic is locked or not.
	 * @var boolean
	 * @access protected
	 */
	protected $locked;

	/**
	 * The number of days to promote a topic at a higher visibility type. If
	 * greater than <tt>zero</tt>, and a type other than <tt>normal</tt> is
	 * selected than this topic will remain at the selected type for the
	 * indicated number of days before reverting back to a <tt>normal</tt> topic
	 * type.
	 * @var int
	 * @access protected
	 */
	protected $promotionDays;

	/**
	 * The poll associated with this topic, <tt>null</tt> if there is no poll.
	 * @var Poll
	 * @access protected
	 */
	protected $poll;

	/**
	 * The [first] post that represents the genesis of the topic.
	 * @var PostInterface
	 * @access protected
	 */
	protected $post;

	/**
	 * The number of posts (inclusive of the first post) in the topic.
	 * @var int
	 * @access protected
	 */
	protected $postCount = 0;

	/**
	 * The number of replies (exclusive of the first post) in the topic.
	 * @var int
	 * @access protected
	 */
	protected $replyCount = 0;

	/**
	 * Whether the topic was reported. A reported topic is visibly identified
	 * and indicates that a moderator should take action to review the topic
	 * for inappropriate content.
	 * @var boolean
	 * @access protected
	 */
	protected $reported = false;

	/**
	 * The title of the topic.
	 * @var string
	 * @access protected
	 */
	protected $title;

	/**
	 * The type of the topic; e.g. normal, sticky, announcement, and global.
	 * If the topic has been marked as "sticky" it will show up before all
	 * normal posts, announcements precede sticky topics, and global topics
	 * preced all others and are visible on all forums.
	 * @var string
	 * @access protected
	 */
	protected $type;

	/**
	 * The user responsible for creating the topic.
	 * @var mixed
	 * @access protected
	 */
	protected $user;

	/**
	 * The number of times that this topic was viewed.
	 * @var int
	 * @access protected
	 */
	protected $viewCount = 0;

	public function __construct()
	{
		$this->approved = true;
		$this->created = new \DateTime;
		$this->lastUpdated = new \DateTime;
		$this->locked = false;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\TopicInterface::getCategory()
	 */
	public function getCategory()
	{
		return $this->category;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\TopicInterface::getCreated()
	 */
	public function getCreated()
	{
		return $this->created;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\ForumAwareInterface::getForum()
	 */
	public function getForum()
	{
		return $this->forum;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\TopicInterface::getId()
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\TopicInterface::getLastPost()
	 */
	public function getLastPost()
	{
		return $this->lastPost;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\TopicInterface::getLastViewed()
	 */
	public function getLastViewed()
	{
		return $this->lastViewed;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\TopicInterface::getLastUpdated()
	 */
	public function getLastUpdated()
	{
		return $this->lastUpdated;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\TopicInterface::getPost()
	 */
	public function getPost()
	{
		return $this->post;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\TopicInterface::getPostCount()
	 */
	public function getPostCount()
	{
		return $this->postCount;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\TopicInterface::getPromotionDays()
	 */
	public function getPromotionDays()
	{
		return $this->promotionDays;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\TopicInterface::getReplyCount()
	 */
	public function getReplyCount()
	{
		return $this->replyCount;
	}

	/**
	 * Returns the title of the the topic thread.
	 * @return string the title of the topic thread.
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\TopicInterface::getType()
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\TopicInterface::getUser()
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\TopicInterface::getViewCount()
	 */
	public function getViewCount()
	{
		return $this->viewCount;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\TopicInterface::isReported()
	 */
	public function isApproved()
	{
		return $this->approved;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\TopicInterface::isLocked()
	 */
	public function isLocked()
	{
		return $this->locked;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\ForumBundle\Model\TopicInterface::isReported()
	 */
	public function isReported()
	{
		return $this->reported;
	}

	public function removePost($post)
	{
		throw new \Exception('Not yet implemented');
	}

	public function setApproved($approved)
	{
		$this->approved = $approved;
	}

	public function setCategory($category)
	{
		$this->category = $category;
	}

	public function setCreated($created)
	{
		$this->created = $created;
	}

	public function setForum(ForumInterface $forum)
	{
		$this->forum = $forum;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function setLastPost($lastPost)
	{
		$this->lastPost = $lastPost;
	}

	public function setLastUpdated($lastUpdated)
	{
		$this->lastUpdated = $lastUpdated;
	}

	public function setLastViewed($lastViewed)
	{
		$this->lastViewed = $lastViewed;
	}

	public function setLocked($locked)
	{
		$this->locked = $locked;
	}

	public function setPoll($poll)
	{
		$this->poll = $poll;
	}

	public function setPost($post)
	{
		$this->post = $post;
	}

	public function setPostCount($postCount)
	{
		$this->postCount = $postCount;
	}

	public function setPromotionDays($promotionDays)
	{
		$this->promotionDays = $promotionDays;
	}

	public function setReplyCount($replyCount)
	{
		$this->replyCount = $replyCount;
	}

	public function setReported($reported)
	{
		$this->reported = $reported;
	}

	public function setTitle($title)
	{
		$this->title = $title;
	}

	public function setType($type)
	{
		$this->type = $type;
	}

	public function setUser($user)
	{
		$this->user = $user;
	}

	public function setViewCount($viewCount)
	{
		$this->viewCount = $viewCount;
	}
}
