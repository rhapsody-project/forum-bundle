<?php
/* Copyright (c) 2015 Rhapsody Project
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
namespace Rhapsody\ForumBundle\Event;

use Rhapsody\ForumBundle\Model\TopicInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Security\Core\User\UserInterface;
use Rhapsody\ForumBundle\Model\PostInterface;

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody ForumBundle
 * @package   Rhapsody\ForumBundle\Event
 * @copyright Copyright (c) 2015 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class TopicEvent extends Event implements TopicEventInterface
{

	/**
	 * The topic.
	 * @var \Rhapsody\ForumBundle\Model\TopicInterface
	 */
	private $topic;

	/**
	 * The post.
	 * @var \Rhapsody\ForumBundle\Model\PostInterface
	 */
	private $post;

	private $user;

	public function __construct()
	{
		// Empty
	}

	public function getPost()
	{
		return $this->post;
	}

	public function getTopic()
	{
		return $this->topic;
	}

	public function getUser()
	{
		return $this->user;
	}

	public function setPost(PostInterface $post)
	{
		$this->post = $post;
	}

	public function setTopic(TopicInterface $topic)
	{
		$this->topic = $topic;
	}

	public function setUser(UserInterface $user)
	{
		$this->user = $user;
	}
}
