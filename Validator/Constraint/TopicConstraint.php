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
namespace Rhapsody\ForumBundle\Validator\Constraint;

use Rhapsody\ForumBundle\Model\TopicAwareInterface;
use Rhapsody\ForumBundle\Model\TopicInterface;

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody ForumBundle
 * @package   Rhapsody\ForumBundle\Validator\Constraint
 * @copyright Copyright (c) 2013 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class TopicConstraint implements Constraint
{

  /**
   * (non-PHPDoc)
   * @see \Rhapsody\ForumBundle\Validator\Constraint::evaluate()
   */
  public function evaluate($object)
  {
    if (!$object instanceof TopicAwareInterface) {
      throw new \InvalidArgumentException(sprintf('The object defined by: %s was not an instance of the TopicAwareInterface. Unable to evaluate for the existence of a topic.', get_class($object)));
    }

    $topic = $object->getTopic();
    if ($topic === null) {
      throw new \NullPointerException(sprintf('Topic property was NULL. Topic is required for %s.', get_class($object)));
    }

    if (!$topic instanceof TopicInterface) {
      throw new \Exception(sprintf('Invalid type assigned to topic property. Value assigned is type of: %s, expected: TopicInterface', get_class($topic)));
    }
  }
}
