<?php
namespace AppBundle\Request;


use AppBundle\Entity\Input\UserPicture;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserPictureParamConverter implements ParamConverterInterface
{
    protected $validator;

    /**
     * The name of the argument on which the ConstraintViolationList will be set.
     *
     * @var null|string
     */
    protected $validationErrorsArgument;

    public function supports(ParamConverter $configuration)
    {
        if (null === $configuration->getClass()) {
            return false;
        }

        return get_class(new UserPicture()) === $configuration->getClass();
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $picture = new UserPicture();
        $picture->image = $request->files->get('image');
        $request->attributes->set($configuration->getName(), $picture);
        $request->attributes->set(
            $this->validationErrorsArgument,
            $this->validator->validate($picture)
        );
    }

    function __construct(ValidatorInterface $validator, $validationErrorsArgument)
    {
        $this->validator = $validator;
        $this->validationErrorsArgument = $validationErrorsArgument;
    }
}