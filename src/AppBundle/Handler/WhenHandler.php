<?php
namespace AppBundle\Handler;

use Symfony\Component\Translation\TranslatorInterface;

class WhenHandler
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * GenderHandler constructor.
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function when(\DateTime $start, $locale = null) {
        $when = '';
        $today = new \DateTime();
        $tomorrow  = new \DateTime();
        $tomorrow->modify('+1 day');
        if ($today->format('d.m.Y') == $start->format('d.m.Y')) {
            $when = 'date.format.today';
        } elseif ($tomorrow->format('d.m.Y') == $start->format('d.m.Y')) {
            $when = 'date.format.tomorrow';
        }

        $whenTitleTranslated = $this->translator->trans($when, [], null, $locale);

        return $whenTitleTranslated;
    }
}