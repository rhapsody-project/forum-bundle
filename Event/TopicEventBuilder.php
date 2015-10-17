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

use Rhapsody\ForumBundle\Model\PostInterface;
use Rhapsody\ForumBundle\Model\TopicInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * An {@link \Rhapsody\ForumBundle\Event\TopicEventInterface} builder.
 *
 * @author    Sean.Quinn
 * @category  Rhapsody ForumBundle
 * @package   Rhapsody\ForumBundle\Event
 * @copyright Copyright (c) 2015 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class TopicEventBuilder
{

	/**
	 * The topic.
	 * @var \Rhapsody\ForumBundle\Model\TopicInterface
	 */
	private $action;

	/**
	 * The post.
	 * @var \Rhapsody\ForumBundle\Model\PostInterface
	 */
	private $post;

	/**
	 * The user.
	 * @var \Symfony\Component\Security\Core\User\UserInterface
	 */
	private $user;

	public static function create()
	{
		return new TopicEventBuilder();
	}

	public function build()
	{
		$topicEvent = new TopicEvent();

		if ($this->topic === null) {
			throw new \NullPointerException("Topic cannot be null for topic event(s).");
		}

		$topicEvent->setTopic($this->topic);

		if ($this->post !== null) {
			$topicEvent->setPost($this->post);
		}

		if ($this->user !== null) {
			$topicEvent->setUser($this->user);
		}
		return $topicEvent;
	}

	public function setTopic(TopicInterface $topic)
	{
		$this->topic = $topic;
		return $this;
	}

	public function setPost(PostInterface $post)
	{
		$this->post = $post;
		return $this;
	}

	public function setUser(UserInterface $user)
	{
		$this->user = $user;
		return $this;
	}
}