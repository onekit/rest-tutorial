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
use AppBundle\Entity\Input\CreateContact;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\HttpFoundation\Response;


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
     * @Sensio\Security("has_role('ROLE_USER')")
     * @Rest\Post("", name="api_post_contact")
     * @Sensio\ParamConverter("createContact", converter = "fos_rest.request_body")
     * @Sensio\ParamConverter("picture", converter="api.converter.contact_picture")
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
     * @App\RestResult(paginate=true, sort={"id"})
     * @Rest\View(serializerGroups={"default","contact_list"})
     * @Rest\QueryParam(name="page", requirements="\d+", default="1", description="Page")
     * @Rest\QueryParam(name="limit", requirements="\d+", default="50", description="Results on page")
     * @Rest\QueryParam(name="orderBy", default="id", description="Order by")
     * @Rest\QueryParam(name="orderDir", default="ASC", description="Order direction")

     * @param string $page
     * @param string $limit
     * @param string $orderBy
     * @param string $orderDir
     * @return Contact[]
     */
    public function getContactListAction($page, $limit, $orderBy, $orderDir)
    {
        return $this->contactManager->getList()->order($orderBy, $orderDir)->paginate($page, $limit);
    }


    /**
     * @ApiDoc(views = {"default", "admin"})
     *
     * @Sensio\Security("has_role('ROLE_ADMIN')")
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


    /**
     * @ApiDoc(
     *      parameters={
     *          {"name"="image", "dataType"="file", "required"=true, "description"="contact picture"}
     *      },
     *      views = {"default", "admin"}
     * )
     *
     * @Sensio\Security("has_role('ROLE_ADMIN')")
     * @Rest\Post("/{id}/picture", name="api_post_contact_picture")
     * @Sensio\ParamConverter("contact", converter="doctrine.orm")
     * @Sensio\ParamConverter("picture", converter="api.converter.contact_picture")
     * @Rest\View(serializerGroups={"default", "contact_picture"})
     *
     * @param Contact $contact
     * @param ContactPicture $picture
     * @return Contact|Response
     */
    public function postPictureAction(Contact $contact, ContactPicture $picture)
    {
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