<?php

namespace spec\Gousto;

use DateTime;
use Gousto\Recipe;
use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RecipeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Recipe::class);
    }

    function it_has_id()
    {
        $this->setId(1);
        $this->getId()->shouldBe(1);
    }

    function it_has_box_type()
    {
        $this->setBoxType('vegetarian');
        $this->getBoxType()->shouldBe('vegetarian');
//        box_type,title,slug,short_title,marketing_description,calories_kcal,protein_grams,fat_grams,carbs_grams,bulletpoint1,bulletpoint2,bulletpoint3,recipe_diet_type_id,season,base,protein_source,preparation_time_minutes,shelf_life_days,equipment_needed,origin_country,recipe_cuisine,in_your_box,gousto_reference
    }

    function it_has_short_title()
    {
        $this->setShortTitle('short_title');
        $this->getShortTitle()->shouldBe('short_title');
    }

    function its_title_creates_slug()
    {
        $title = 'Sweet Chilli and Lime Beef on a Crunchy Fresh Noodle Salad';
        $this->setTitle($title);
        $this->getTitle()->shouldBe($title);
        $this->getSlug()->shouldBe('sweet-chilli-and-lime-beef-on-a-crunchy-fresh-noodle-salad');
    }

    function it_has_marketing_description()
    {
        $this->setMarketingDescription('marketing description');
        $this->getMarketingDescription()->shouldBe('marketing description');
    }

    function it_has_calories()
    {
        $this->setCalories(400);
        $this->getCalories()->shouldBe(400);
    }

    function it_has_protein()
    {
        $this->setProtein(12);
        $this->getProtein()->shouldBe(12);
    }

    function it_has_fat()
    {
        $this->setFat(23);
        $this->getFat()->shouldBe(23);
    }

    function it_has_carbs()
    {
        $this->setCarbs(12);
        $this->getCarbs()->shouldBe(12);
    }

    function it_has_bulletpoints()
    {
        $this->setBulletPoint1('b1');
        $this->getBulletPoint1()->shouldBe('b1');
        $this->setBulletPoint2('b2');
        $this->getBulletPoint2()->shouldBe('b2');
        $this->setBulletPoint3('b3');
        $this->getBulletPoint3()->shouldBe('b3');
    }

    function it_has_dietType()
    {
        $this->setDietTypeId('meat');
        $this->getDietTypeId()->shouldBe('meat');
    }

    function it_has_season()
    {
        $this->setSeason('all');
        $this->getSeason()->shouldBe('all');
    }

    function it_has_base()
    {
        $this->setBase('noodles');
        $this->getBase()->shouldBe('noodles');
    }

    function it_has_protein_source()
    {
        $this->setProteinSource('beef');
        $this->getProteinSource()->shouldBe('beef');
    }

    function it_has_preparation_time()
    {
        $this->setPreparationTime(45);
        $this->getPreparationTime()->shouldBe(45);
    }

    function it_has_shelf_life()
    {
        $this->setShelfLife(2);
        $this->getShelfLife()->shouldBe(2);
    }

    function it_needs_equipment()
    {
        $this->setEquipmentNeeded('appetite');
        $this->getEquipmentNeeded()->shouldBe('appetite');
    }

    function it_has_origin_country()
    {
        $this->setOriginCountry('UK');
        $this->getOriginCountry()->shouldBe('UK');
    }

    function it_has_cuisine()
    {
        $this->setCuisine('asian');
        $this->getCuisine()->shouldBe('asian');
    }

    function it_has_in_your_box()
    {
        $this->setInYourBox('in');
        $this->getInYourBox()->shouldBe('in');
    }

    function it_has_goustoReference()
    {
        $this->setGoustoReference(23);
        $this->getGoustoReference()->shouldBe(23);
    }

    function it_has_created_date()
    {
        $this->setCreatedAt(new DateTime());
        $this->getCreatedAt()->shouldBeAnInstanceOf(DateTime::class);
    }

    function it_has_updated_date()
    {
        $this->setUpdatedAt(new DateTime());
        $this->getUpdatedAt()->shouldBeAnInstanceOf(DateTime::class);
    }

    function its_constructed_from_array()
    {
        $this->beConstructedThrough('fromStorage', [['title'=> 'title']]);
        $this->getTitle()->shouldBe('title');
    }

    function it_has_data()
    {
        $this->setTitle('title');
        $this->getData()['title']->shouldBe('title');
    }

    function it_sets_slug()
    {
        $this->setSlug('slug');
        $this->getSlug()->shouldBe('slug');
    }

    function it_can_be_rated()
    {
        $this->setRating(3);
        $this->getRating()->shouldBe(3);
    }

    function it_cannnot_be_rated_outside_1_to_5()
    {
        $this->shouldThrow(InvalidArgumentException::class)->duringSetRating(-1);
        $this->shouldThrow(InvalidArgumentException::class)->duringSetRating(6);
    }
}
