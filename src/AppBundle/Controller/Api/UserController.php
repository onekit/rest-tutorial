<?php

namespace AppBundle\Controller\Api;

use AppBundle\Manager\UserManager;
use JMS\DiExtraBundle\Annotation as DI;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Sensio;
use FOS\RestBundle\Controller\Annotations as Rest;
use AppBundle\Annotation as App;

use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializationContext;
use AppBundle\Entity\Input\CreateUser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Query\Expr;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Validator\ConstraintViolationListInterface;


/**
 * API User controller.++
 * @Route("/users")
 *
 * @App\RestResult
 */
class UserController extends RestController
{
    /**
     * @var UserManager
     */
    protected $userManager;

    /**
     * @DI\InjectParams({
     *     "userManager" = @DI\Inject("manager.user")
     * })
     *
     * @param UserManager $userManager
     */
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @ApiDoc(input = "\AppBundle\Entity\Input\CreateUser", views = {"default", "admin"})
     *
     * @Sensio\Security("has_role('ROLE_SUPER_ADMIN')")
     * @Rest\Post("", name="api_post_user")
     * @Rest\View(statusCode=201, serializerGroups={"default", "user"})
     *
     * @param CreateUser $createUser
     * @param ConstraintViolationListInterface $constraints
     * @return \AppBundle\Entity\User|Response
     */
    public function postUserAction(CreateUser $createUser, ConstraintViolationListInterface $constraints)
    {
        if ($constraints->count()) {
            return $this->handleError('Validation errors', $constraints);
        }
        return $this->userManager->create($createUser);
    }

    /**
     * @ApiDoc(views = {"default", "admin"})
     *
     * @Sensio\Security("has_role('ROLE_SUPER_ADMIN')")
     * @Rest\Get("/{id}", name="api_get_user", requirements={"id" = "\d+"})
     * @Sensio\ParamConverter("user", converter="doctrine.orm")
     * @Rest\View(serializerGroups={"default", "user"})
     *
     * @param User $user
     * @return User
     */
    public function getUserAction(User $user)
    {
        return $user;
    }

    /**
     * @ApiDoc(views = {"default", "admin"})
     *
     * @Sensio\Security("has_role('ROLE_SUPER_ADMIN')")
     * @Rest\Get("", name="api_get_user_list")
     * @App\RestResult(paginate=true, sort={"id", "username", "email", "created"})
     * @Rest\View(serializerGroups={"default"})
     * @Rest\QueryParam(name="page", requirements="\d+", default="1", description="Page")
     * @Rest\QueryParam(name="limit", requirements="\d+", default="50", description="Results on page")
     * @Rest\QueryParam(name="orderBy", default="id", description="Order by")
     * @Rest\QueryParam(name="orderDir", default="ASC", description="Order direction")
     *
     * @param $page
     * @param $limit
     * @param $order
     * @param $direction
     * @return User[]
     */
    public function getUserListAction($page, $limit, $order, $direction)
    {
        return $this->userManager->getList()->order($order, $direction)->paginate($page, $limit);
    }

    /**
     * @ApiDoc(input = "\AppBundle\Entity\Input\CreateUser", views = {"default", "admin"})
     *
     * @Sensio\Security("has_role('ROLE_SUPER_ADMIN')")
     * @Rest\Put("/{id}", name="api_put_user", requirements={"id" = "\d+"})
     * @Sensio\ParamConverter("user", converter="doctrine.orm")
     * @Rest\View(serializerGroups={"default", "user"})
     *
     *
     * @param User $user
     * @param CreateUser $createUser
     * @return User
     */
    public function putUserAction(User $user, CreateUser $createUser)
    {
        return $this->userManager->updateUser($user, $createUser);
    }

    /**
     * @ApiDoc(views = {"default", "admin"})
     *
     * @Sensio\Security("has_role('ROLE_SUPER_ADMIN')")
     * @Rest\Delete("/{id}", name="api_delete_user", requirements={"id" = "\d+"})
     * @Sensio\ParamConverter("user", converter="doctrine.orm")
     * @Rest\View()
     *
     * @param User $user
     */
    public function deleteUserAction(User $user)
    {
        $this->userManager->delete($user);
    }
}
