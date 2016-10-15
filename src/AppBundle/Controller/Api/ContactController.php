<?php
namespace AppBundle\Controller\Api;


use JMS\DiExtraBundle\Annotation as DI;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Sensio;
use AppBundle\Annotation as App;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View as ViewAnnotation;

use AppBundle\Entity\Contact;
use AppBundle\Manager\ContactManager;
use AppBundle\Entity\Input\CreateContact;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class ContactController
 * @package AppBundle\Controller\Api
 *
 * @Sensio\Route("/contacts")
 * @App\RestResult
 */
class ContactController extends RestController
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
     * @ApiDoc(input = "AppBundle\Entity\Input\CreateContact", views = {"default", "admin"})
     *

     * @Rest\Post("", name="api_post_contact")
     * @Sensio\ParamConverter("createContact", converter = "fos_rest.request_body")
     * @Rest\View(statusCode=201, serializerGroups={"default", "contact"})
     *
     * @param CreateContact $createContact
     * @param ConstraintViolationListInterface $constraints
     * @return Contact|Response
     */
    public function postContactAction(CreateContact $createContact, ConstraintViolationListInterface $constraints)
    {
        if ($constraints->count()) {
            return $this->handleError('Validation errors', $constraints);
        }
        return $this->contactManager->create($createContact);
    }


    /**
     * @ApiDoc(views = {"default", "admin"})
     *
     * @Sensio\Security("is_granted('delete', contact)")
     * @Rest\Delete("/{id}", name="api_delete_contact", requirements={"id" = "\d+"})
     * @Sensio\ParamConverter("contact", converter="doctrine.orm")
     * @Rest\View()
     *
     * @param Contact $contact
     */
    public function deleteContactAction(Contact $contact)
    {
        $this->contactManager->delete($contact);
    }
}