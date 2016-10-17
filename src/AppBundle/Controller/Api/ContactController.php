<?php
namespace AppBundle\Controller\Api;


use JMS\DiExtraBundle\Annotation as DI;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Sensio;
use AppBundle\Annotation as App;

use FOS\RestBundle\Controller\Annotations\View as ViewAnnotation;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Context\Context;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

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
     * @ApiDoc(input = "AppBundle\Entity\Input\CreateContact", views = {"default", "admin"})
     *
     * @Sensio\Security("has_role('ROLE_USER')")
     * @Rest\Put("/{id}", name="api_put_contact")
     * @Sensio\ParamConverter("contact", converter="doctrine.orm")
     * @Sensio\ParamConverter("createContact", converter = "fos_rest.request_body")
     * @Rest\View(serializerGroups={"default", "contact"})
     *
     * @param Contact $contact
     * @param CreateContact $createContact
     * @param ConstraintViolationListInterface $constraints
     * @return Contact|Response
     */
    public function putContactAction(Contact $contact, CreateContact $createContact, ConstraintViolationListInterface $constraints)
    {
        if ($constraints->count()) {
            return $this->handleError('Validation errors', $constraints);
        }
        return $this->contactManager->update($contact, $createContact);
    }

    /**
     * @ApiDoc(views = {"default", "admin"})
     *
     * @Sensio\Security("has_role('ROLE_USER')")
     * @Rest\Get("", name="api_get_contact_list")
     * @App\RestResult(paginate=true, sort={"when"})
     * @Rest\View(serializerGroups={"default"})
     *
     * @param $page
     * @param $limit
     * @param $order
     * @param $direction
     * @return Contact[]
     */
    public function getContactListAction($order, $direction, $page, $limit)
    {
        return $this->contactManager->getList()->order($order, $direction)->paginate($page, $limit);
    }


    /**
     * @ApiDoc(views = {"default", "admin"})
     *
     * @Sensio\Security("is_granted('view', contact)")
     * @Rest\Get("/{id}", name="api_get_contact", requirements={"id" = "\d+"})
     * @Sensio\ParamConverter("contact", converter="doctrine.orm")
     * @Rest\View(serializerGroups={"default", "contact"})
     *
     * @param Contact $contact
     * @return Contact
     */
    public function getContactAction(Contact $contact)
    {
        return $contact;
    }

    /**
     * @ApiDoc(views = {"default", "admin"})
     *
     * @Sensio\Security("has_role('ROLE_ADMIN')")
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