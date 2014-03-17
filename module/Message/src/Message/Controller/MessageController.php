<?php
namespace Message\Controller;

use Nakade\Abstracts\AbstractController;
use Message\Form\MessageForm;
use Message\Form\ReplyForm;
use Zend\View\Model\ViewModel;

/**
 * League tables and schedules of the actual season.
 * Top league table is presented by the default action index.
 * ActionSeasonServiceFactory is needed to be set.
 *
 * @author Holger Maerz <holger@nakade.de>
 */
class MessageController extends AbstractController
{

    /**
    * Default action showing up the Top League table
    * in a short and compact version. This can be used as a widget.
    */
    public function indexAction()
    {
        if ($this->identity() === null) {
           return $this->redirect()->toRoute('login');
        }

        $messages = $this->getService()->getAllMyMessages();
        return new ViewModel(
            array('messages' => $messages)
        );
    }

    /**
     * Default action showing up the Top League table
     * in a short and compact version. This can be used as a widget.
     */
    public function sentAction()
    {
        if ($this->identity() === null) {
            return $this->redirect()->toRoute('login');
        }

        $messages = $this->getService()->getAllMyMessages();
        return new ViewModel(
            array('messages' => $messages)
        );
    }


    public function showAction()
    {
        if ($this->identity() === null) {
           return $this->redirect()->toRoute('login');
        }

        $id  = (int) $this->params()->fromRoute('id', 0);
        $messages = $this->getService()->getMessagesById($id);

        $lastMessage = $this->getService()->getLastMessagesById($id);

        //set read date if not set yet
        if (is_null($lastMessage->getReadDate())) {
            $lastMessage->setReadDate(new \DateTime());
            $this->getService()->getMapper('message')->save($lastMessage);

        }

        return new ViewModel(
            array (
              //'title'     => $this->getService()->getTitle(),
                'messages'  => $messages,
                'replyId'   => $lastMessage->getId(),
            )
        );
    }

    public function newAction()
    {

       if ($this->identity() === null) {
           return $this->redirect()->toRoute('login');
       }

       $id = $this->identity()->getId();
       $recipients = $this->getService()->getAllRecipients($id);

       $message = new \Message\Entity\Message();
       $message->setSender($id);

       $form = new MessageForm($recipients);
       $form->bindEntity($message);

       if ($this->getRequest()->isPost()) {

            //get post data, set data to from, prepare for validation
            $postData =  $this->getRequest()->getPost();

            //cancel
            if ($postData['cancel']) {
                return $this->redirect()->toRoute('message');
            }

            $form->setData($postData);

            if ($form->isValid()) {

                $message = $form->getData();

                //date
                $message->setSendDate(new \DateTime());

                $sender = $this->getService()
                    ->getUserById($message->getSender());
                //sender
                $message->setSender($sender);

                $recipient = $this->getService()
                    ->getUserById($message->getReceiver());
                //receiver
                $message->setReceiver($recipient);

                $this->getService()->getMapper('message')->save($message);

                return $this->redirect()->toRoute('message');
            }
       }


        return new ViewModel(
            array('form' => $form)
        );
    }

    public function replyAction()
    {

       if ($this->identity() === null) {
           return $this->redirect()->toRoute('login');
       }

       $id  = (int) $this->params()->fromRoute('id', 1);
       $message = $this->getService()->getLastMessagesById($id);


       $sender = $message->getSender();
       $message->setSubject('Re: '.$message->getSubject());
      // var_dump($message);
       $form = new ReplyForm($sender);
       $form->bindEntity($message);



       if ($this->getRequest()->isPost()) {

            //get post data, set data to from, prepare for validation
            $postData =  $this->getRequest()->getPost();

            //cancel
            if ($postData['cancel']) {
                return $this->redirect()->toRoute('message');
            }

            $form->setData($postData);

            if ($form->isValid()) {

                $message = $form->getData();
                $sender = $message->getSender();
                $recipient = $message->getReceiver();
var_dump($message); die;
                //date
                $message->setSendDate(new \DateTime());

                $sender = $this->getService()
                    ->getUserById($message->getSender());
                //sender
                $message->setSender($sender);

                $recipient = $this->getService()
                    ->getUserById($message->getReceiver());
                //receiver
                $message->setReceiver($recipient);

                $this->getService()->getMapper('message')->save($message);

                return $this->redirect()->toRoute('message');
            }
        }


        return new ViewModel(
           array('form' => $form)
        );
    }

    /**
     * @return \Zend\Http\Response|ViewModel
     */
    public function archiveAction()
    {
        if ($this->identity() === null) {
            return $this->redirect()->toRoute('login');
        }



        return new ViewModel(
            array (

            )
        );
    }


}
