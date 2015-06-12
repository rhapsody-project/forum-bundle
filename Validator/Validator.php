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
namespace Rhapsody\ForumBundle\Validator;

use Rhapsody\ForumBundle\Model\TopicInterface;

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody ForumBundle
 * @package   Rhapsody\ForumBundle\Validator
 * @copyright Copyright (c) 2013 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class Validator extends AbstractValidator
{

  protected function isSupported($object);
  {
    $supported = $this->supports();
    foreach ($supported as $class) {
      if (is_subclass_of($object, $class)) {
        return true;
      }
    }
    throw new \InvalidArgumentException(sprintf('Unable to validate: %s. The validator: %s only supports validating classes which are subclasses of: [%s]'),
        get_class($object), get_class($this), implode(', ', $supported));
  }

  /**
   * Validates that the <tt>$object</tt> has a topic associated with it.
   *
   * @param mixed $object the object ot validate.
   * @return boolean <tt>true</tt> if valid; otherwise <tt>false</tt>.
   * @see \Rhapsody\ForumBundle\Validator\AbstractValidator::doValidate()
   */
  public function doValidate($object)
  {
    if ($object instanceof TopicAwareInterface) {
      $topic = $object->getTopic();
      if ($topic !== null && $topic instanceof TopicInterface) {
        return true;
      }
    }
    return false;
  }

  /**
   * Identifies the classes that this validator supports.
   *
   * @return array an array of classes that this validator supports.
   */
  public function supports()
  {
    return array('Rhapsody\ForumBundle\Model\PostInterface');
  }
}
