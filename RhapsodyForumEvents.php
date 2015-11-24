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
namespace Rhapsody\ForumBundle;

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody ForumBundle
 * @package   Rhapsody\ForumBundle
 * @copyright Copyright (c) 2013 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class RhapsodyForumEvents
{

	/**
	 * The NEW_TOPIC event occurs when a user creates a new topic.
	 *
	 * This event allows the forum bundle to alert individuals watching a forum
	 * or category of new posts.
	 *
	 * The event listener method receives a \Rhapsody\ForumBundle\Event\TopicEvent instance.
	 */
	const NEW_TOPIC = 'rhapsody.forum.event.topic.new';

	/**
	 * The POST_EDITED event occurs when a post is edited by a user.
	 *
	 * This event allows the forum bundle to notify participants in a post
	 * discussion that a post has been edited, based on their notification
	 * preferences.
	 *
	 * The event listener method receives a \Rhapsody\SocialBundle\Event\TopicEvent instance.
	 */
	const POST_EDITED = 'rhapsody.forum.event.post.edited';

	/**
	 * The REPLY_TO_TOPIC event occurs when a user posts a reply to a topic.
	 *
	 * This event allows the forum bundle to notify participants of a topic
	 * discussion that a new post has been added.
	 *
	 * The event listener method receives a \Rhapsody\ForumBundle\Event\TopicEvent instance.
	 */
	const REPLY_TO_TOPIC = 'rhapsody.forum.event.topic.reply';

	/**
	 * The VIEW_TOPIC event occurs when a user views a topic.
	 *
	 * This event allows the forum bundle to update statistics on the topic being
	 * viewed.
	 *
	 * The event listener method receives a \Rhapsody\ForumBundle\Event\TopicEvent instance.
	 */
	const VIEW_TOPIC = 'rhapsody.forum.event.topic.view';
}
