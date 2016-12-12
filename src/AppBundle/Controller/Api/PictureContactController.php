<?php
namespace AppBundle\Controller\Api;


use JMS\DiExtraBundle\Annotation as DI;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Sensio;
use AppBundle\Annotation as App;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use AppBundle\Entity\Contact;
use AppBundle\Entity\Input\ContactPicture;
use AppBundle\Manager\ContactManager;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class ContactController
 * @package AppBundle\Controller\Api
 *
 * @Sensio\Route("/contacts")
 * @App\RestResult
 */
class PictureContactController extends RestController
{

    /**
     * @var ContactManager
     */
    protected $contactManager;

    /**
     * @DI\InjectParams({
     *     "contactManager" = @DI\Inject("api.manager.contact")
     * })
     *
     * @param ContactManager $contactManager
     */
    public function __construct(ContactManager $contactManager)
    {
        $this->contactManager = $contactManager;
    }


    /**
     * @ApiDoc(
     *      parameters={
     *          {"name"="image", "dataType"="file", "required"=true, "description"="contact picture"}
     *      },
     *      views = {"default", "admin"}
     * )
     *
     * @Sensio\Security("has_role('ROLE_ADMIN')")
     * @Rest\Post("/{id}/picture", name="api_post_contact_picture", requirements={"id" = "\d+"})
     * @Sensio\ParamConverter("picture", converter="api.converter.contact_picture")
     * @Rest\View(serializerGroups={"default", "contact_picture"})
     *
     * @param Contact $contact
     * @param ContactPicture $picture
     * @param ConstraintViolationListInterface $validationErrors
     * @return Contact|Response
     */
    public function postPictureAction(Contact $contact, ContactPicture $picture, ConstraintViolationListInterface $validationErrors)
    {
        if ($validationErrors->count()) {
            return $this->handleError('Validation errors', $validationErrors);
        }
        $contact = $this->contactManager->setPicture($contact, $picture);
        return $contact;
    }

    /**
     * @ApiDoc(views = {"default", "admin"})
     *
     * @Sensio\Security("has_role('ROLE_ADMIN')")
     * @Rest\Get("/{id}/picture", name="api_get_contact_picture", requirements={"id" = "\d+"})
     * @Sensio\ParamConverter("contact", converter="doctrine.orm")
     * @Rest\View(serializerGroups={"default", "contact_picture"})
     *
     * @param Contact $contact
     * @return Contact
     */
    public function getPictureAction(Contact $contact)
    {
        return $contact;
    }

    /**
     * @ApiDoc(views = {"default", "admin"})
     *
     * @Sensio\Security("has_role('ROLE_ADMIN')")
     * @Rest\Delete("/{id}/picture", name="api_delete_contact_picture", requirements={"id" = "\d+"})
     * @Sensio\ParamConverter("contact", converter="doctrine.orm")
     * @Rest\View(serializerGroups={"default", "contact_picture"})
     *
     * @param Contact $contact
     * @return Contact
     */
    public function deletePictureAction(Contact $contact)
    {
        $contact = $this->contactManager->setPicture($contact);
        return $contact;
    }

}