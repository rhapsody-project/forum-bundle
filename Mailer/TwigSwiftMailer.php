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
namespace Rhapsody\ForumBundle\Mailer;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody ForumBundle
 * @package   Rhapsody\ForumBundle\Mailer
 * @copyright Copyright (c) 2013 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class TwigSwiftMailer implements MailerInterface
{
	/**
	 * The configured mailer for sending email messages.
	 * @var \Swift_Mailer
	 */
	protected $mailer;
	protected $router;
	protected $twig;

	public function __construct(\Swift_Mailer $mailer, UrlGeneratorInterface $router, \Twig_Environment $twig)
	{
		$this->mailer = $mailer;
		$this->router = $router;
		$this->twig = $twig;
	}

	/**
	 * Prepares an email message, defined by the {@code Application\LorecallBundle\Model\MessageTemplate},
	 * to be sent by rendering the HTML and text parts of the message.
	 *
	 * @param MessageTemplate $template
	 * @param array $data
	 */
	protected function prepare(MessageTemplate $messageTemplate, array $data = array())
	{
		$template = $this->twig->loadTemplate($messageTemplate->getTemplate());

		if ($template->hasBlock('subject')) {
			$subject = $template->renderBlock('subject', $data);
			$messageTemplate->setSubject($subject);
		}

		$rendered = $template->renderBlock('body_html', $data);
		$messageTemplate->setBody($rendered);

		$text = $template->renderBlock('body_text', $data);
		if (empty($text)) {
			$text = strip_tags($rendered);
		}
		$messageTemplate->setTextBody($text);
	}

	/**
	 *
	 * @param MessageTemplate $template
	 * @param array $data
	 */
	public function sendMessage($template, array $data = array())
	{
		if (!($template instanceof MessageTemplate)) {
			throw new InvalidArgumentException('The template must be an instance of the MessageTemplate class.');
		}

		$this->prepare($template, $data);

		$message = \Swift_Message::newInstance()
				->setSubject($template->getSubject())
				->setFrom($template->getFrom())
				->setTo(array($template->getTo()));

		$html = $template->getBody();
		$text = $template->getTextBody();
		if (!empty($html)) {
			$message->setBody($html, 'text/html')
					->addPart($text, 'text/plain');
		}
		else {
			$message->setBody($text);
		}
		$this->mailer->send($message);
	}
}