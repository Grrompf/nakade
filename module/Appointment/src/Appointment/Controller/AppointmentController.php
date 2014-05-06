<?php
/**
 * Controller Appointment
 *
 * @author Dr. Holger Maerz <holger@spandaugo.de>
 */

// module/Appointment/src/Appointment/Controller/AppointmentController.php:
namespace Appointment\Controller;

use Appointment\Entity\Appointment;
use League\Entity\Match;
use Appointment\Form\AppointmentForm;
use Appointment\Form\ConfirmForm;
use Appointment\Form\RejectForm;
use Zend\View\Model\ViewModel;
use Nakade\Abstracts\AbstractController;
/**
<p>
    <div><?php echo $this->translate("If you use ICal, make sure to update."); ?></div>
<div><?php echo $this->translate("Therefore, just download your match schedule again."); ?></div>
</p>

*/
//
// 2. email
// 2b factories for controller, form and email
// 4. confirm by email
// 5. automatic confirm after time exceed
// login message for awaiting confirmation or rejecting
// css for bootstrap
//rejectReason for admin
// unit test

class AppointmentController extends AbstractController
{

    private $homeRoute = 'home';

    /**
     * @return array|ViewModel
     */
   public function indexAction()
   {
       $matchId  = (int) $this->params()->fromRoute('id', -1);

       /* @var $repo \League\Mapper\MatchMapper */
       $repo = $this->getRepository()->getMapper('match');

       /* @var $match \League\Entity\Match */
       $match = $repo->getMatchById($matchId);

       //noAppointment made for this match
       //user is either black or white
       //match has no result
      /* if (is_null($match) || $match->hasResult() || $this->hasAppointment($match) || !$this->isValidUser($match)) {
          return $this->redirect()->toRoute('appointment', array(
              'action' => 'invalid'
          ));
       }*/

       $appointment = $this->makeAppointmentByUser($match);

       /* @var $form \Appointment\Form\AppointmentForm */
       $form = $this->getFormFactory()->getForm('appointment');
       $form->bindEntity($appointment);

       /* @var $request \Zend\Http\Request */
       $request = $this->getRequest();
       if ($request->isPost()) {

           $postData =  $request->getPost();

           //cancel
           if ($postData['cancel']) {
               return $this->redirect()->toRoute($this->homeRoute);
           }

           $form->setData($postData);

           if ($form->isValid()) {

               $data = $form->getData();
               $repo->save($data);


              //make email: submitter & responder
               //send email
               //

               return $this->redirect()->toRoute('appointment', array(
                   'action' => 'success'
               ));
           }
       }


       return new ViewModel(
           array(
               'form' => $form,
               'match' => $match
           )
       );
   }

    /**
     * @return array|ViewModel
     */
    public function confirmAction()
    {

        // todo: confirmation deadline if excceding time period for confirming: automatic confirmation!

        //provide appointmentId
        $appointmentId  = (int) $this->params()->fromRoute('id', -1);

        //proof on matching user

        /* @var $repo \Appointment\Mapper\AppointmentMapper */
        $repo = $this->getRepository()->getMapper('appointment');
        $appointment = $repo->getAppointmentById($appointmentId);

        //appointment is not confirmed or rejected
        //user is either black or white
        //match has no result
    /*    if (is_null($appointment) || $this->isProcessed($appointment) || !$this->isValidUser($appointment->getMatch()) || $appointment->getMatch()->hasResult()) {
            return $this->redirect()->toRoute('appointment', array(
                'action' => 'invalid'
            ));
        }*/

        /* @var $form \Appointment\Form\ConfirmForm */
        $form = $this->getFormFactory()->getForm('confirm');
        $form->bindEntity($appointment);

        if ($this->getRequest()->isPost()) {

            //get post data, set data to from, prepare for validation
            $postData =  $this->getRequest()->getPost();

            //reject
            if ($postData['reject']) {
                return $this->redirect()->toRoute('appointment', array(
                        'action' => 'reject',
                        'id' => $appointmentId,
                ));
            }

            $form->setData($postData);

            if ($form->isValid() && $postData['confirm']) {

                /* @var $appointment \Appointment\Entity\Appointment */
                $appointment = $form->getData();

                $match = $appointment->getMatch();
                $date = $appointment->getNewDate();

                $appointment->setIsConfirmed(true);
                $match->setDate($date);

                $repo->save($appointment);
                $repo->save($match);

                //make email : confirm
                //send email to both players

                return $this->redirect()->toRoute('appointment', array(
                    'action' => 'success'
                ));
            }
        }


        return new ViewModel(
            array(
                'oldDate' => $appointment->getOldDate()->format('d.m.Y H:i'),
                'newDate' => $appointment->getNewDate()->format('d.m.Y H:i'),
                'form' => $form,
                'matchInfo' => $appointment->getMatch()->getMatchInfo()
            )
        );
    }

    /**
     * @return array|ViewModel
     */
    public function rejectAction()
    {

        //provide appointmentId
        $appointmentId  = (int) $this->params()->fromRoute('id', -1);

        /* @var $repo \Appointment\Mapper\AppointmentMapper */
        $repo = $this->getRepository()->getMapper('appointment');
        $appointment = $repo->getAppointmentById($appointmentId);

        //appointment is not confirmed or rejected
        //user is either black or white
        //match has no result
    /*    if (is_null($appointment) || $this->isProcessed($appointment) || !$this->isValidUser($appointment->getMatch()) || $appointment->getMatch()->hasResult()) {
            return $this->redirect()->toRoute('appointment', array(
                'action' => 'invalid'
            ));
        }*/

        /* @var $form \Appointment\Form\RejectForm */
        $form = $this->getFormFactory()->getForm('reject');
        $form->bindEntity($appointment);

        if ($this->getRequest()->isPost()) {

            //get post data, set data to from, prepare for validation
            $postData =  $this->getRequest()->getPost();

            //cancel
            if ($postData['cancel']) {
                return $this->redirect()->toRoute('appointment', array(
                    'action' => 'confirm',
                    'id' => $appointmentId
                ));
            }

            $form->setData($postData);

            if ($form->isValid() && $postData['reject']) {

                $appointment = $form->getData();
                $appointment->setIsRejected(true);
                $repo->save($appointment);

                //make email : reject
                //send email to both players and league managers

                return $this->redirect()->toRoute('appointment', array(
                    'action' => 'info'
                ));
            }
        }


        return new ViewModel(
            array(
                'oldDate' => $appointment->getOldDate()->format('d.m.Y H:i'),
                'newDate' => $appointment->getNewDate()->format('d.m.Y H:i'),
                'form' => $form,
                'matchInfo' => $appointment->getMatch()->getMatchInfo()
            )
        );
    }

    /**
     * @return array|ViewModel
     */
    public function successAction()
    {
        return new ViewModel();
    }

    /**
     * @return array|ViewModel
     */
    public function infoAction()
    {
        return new ViewModel(
            array()
        );
    }

    /**
     * @return array|ViewModel
     */
    public function invalidAction()
    {
        return new ViewModel(
            array()
        );
    }

    /**
     * @param Match $match
     *
     * @return Appointment
     */
    private function makeAppointmentByUser(Match $match)
    {
        /* @var $user \User\Entity\User */
        $user = $this->identity();

        $appointment = new Appointment();

        $appointment->setMatch($match);
        $appointment->setSubmitDate(new \DateTime());
        $appointment->setOldDate($match->getDate());

        $responder = $match->getBlack();
        $submitter = $match->getWhite();
        if ($user->getId() == $match->getBlack()->getId()) {
            $submitter = $match->getBlack();
            $responder = $match->getWhite();
        }
        $appointment->setSubmitter($submitter);
        $appointment->setResponder($responder);

        return $appointment;

    }

    /**
     * @param Appointment $appointment
     *
     * @return bool
     */
    private function isProcessed(Appointment $appointment)
    {

        if ($appointment->isRejected() || $appointment->isConfirmed()) {
            return true;
        }
        return false;

        //return $this->isValidMatch($appointment->getMatch());
    }
    /**
     * @param Match $match
     *
     * @return bool
     */
    private function isValidUser(Match $match)
    {
        /* @var $user \User\Entity\User */
        $user = $this->identity();
        if ($match->getBlack()->getId() == $user->getId()) {
            return true;
        }

        if ($match->getWhite()->getId() == $user->getId()) {
            return true;
        }

        return false;
    }


    /**
     * @param Match $match
     *
     * @return bool
     */
    private function hasAppointment(Match $match)
    {
        $result = $this->getRepository()->getMapper('appointment')->getAppointmentByMatch($match);
        return empty($result);

    }
}