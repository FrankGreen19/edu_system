<?php


namespace App\Tests\Resource\Fixture;


use App\Entity\Group;
use App\Entity\TestQuestion;
use App\Entity\Question;
use App\Entity\QuestionCategory;
use App\Entity\Role;
use App\Entity\Test;
use App\Entity\TestType;
use App\Entity\User;
use App\Tests\Tools\FakerTool;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixture extends Fixture
{
    use FakerTool;

    public function load(ObjectManager $manager)
    {
        $faker = $this->getFaker();

        $groups = [];
        for ($i = 0; $i <= 2; $i++) {
            $group = new Group();
            $group->setTitle($this->getFaker()->numerify());

            $manager->persist($group);
            $manager->flush();
            
            $groups[] = $group;
        }
        
        $rolePupil = new Role();
        $rolePupil->setTitle('ROLE_PUPIL');
        $manager->persist($rolePupil);

        $roleTeacher = new Role();
        $roleTeacher->setTitle('ROLE_TEACHER');
        $manager->persist($roleTeacher);
        
        $manager->flush();

        $author = new User();
        foreach ($groups as $group) {
            for ($i = 0; $i <= 7; $i++) {
                $user = new User();
                $user->setEmail($this->getFaker()->email());
                $user->setPassword($this->getFaker()->password());
                $user->setLastName($this->getFaker()->lastName());
                $user->setFirstName($this->getFaker()->firstName());
                $user->setActive(User::ACTIVE_YES);
                $user->addRelatedGroup($group);
                $user->addRole($rolePupil);

                $manager->persist($user);
                $manager->flush();
            }

            $user = new User();
            $user->setEmail($this->getFaker()->email());
            $user->setPassword($this->getFaker()->password());
            $user->setLastName($this->getFaker()->lastName());
            $user->setFirstName($this->getFaker()->firstName());
            $user->setActive(User::ACTIVE_YES);
            $user->addRelatedGroup($group);
            $user->addRole($roleTeacher);

            $manager->persist($user);
            $manager->flush();
            $author = $user;
        }

        $qCategories = [];

        $qCategory = new QuestionCategory();
        $qCategory->setTitle('Значение логического выражения');
        $qCategories[] = $qCategory;

        $qCategoryAuthored = new QuestionCategory();
        $qCategoryAuthored->setTitle('Какая-то авторская категория');
        $qCategoryAuthored->setAuthor($author);
        $qCategories[] = $qCategoryAuthored;

        $manager->persist($qCategory);
        $manager->persist($qCategoryAuthored);
        $manager->flush();

        $testTypeCustom = new TestType();
        $testTypeCustom->setTitle('custom');
        $testTypeGenerated = new TestType();
        $testTypeGenerated->setTitle('generated');

        $manager->persist($testTypeCustom);
        $manager->persist($testTypeGenerated);
        $manager->flush();

        foreach ($qCategories as $category) {
            $test = new Test();
            $test->setTitle($faker->words(3, true));
            $test->setTheme($faker->words(1, true));
            if ($category->getTitle() === 'Какая-то авторская категория') {
                $test->setQuestionCategory($category);
                $test->setAuthor($author);
                $test->setTestType($testTypeCustom);
            } else {
                $test->setTestType($testTypeGenerated);
                $test->setQuestionCategory($category);
            }

            $test->setQuestionsNumber(10);
            $test->setCreateDate(new \DateTime());
            $test->setFinishDate($test->getCreateDate()->add(new \DateInterval('P7D')));
            $test->setExecutionTime(new \DateTime());

            for ($i = 0; $i <= 10; $i++) {
                $question = new Question();
                $question->setQuestionCategory($category);
                $question->setDescription($faker->words(10, true));
                $question->setAnswer($faker->word());

                $manager->persist($question);
                $manager->flush();

                if ($category->getTitle() === 'Какая-то авторская категория') {
                    $orderedTestQuestion = new TestQuestion();
                    $orderedTestQuestion->setQuestion($question);
                    $orderedTestQuestion->setTest($test);
                    $orderedTestQuestion->setSortOrder($i);

                    $manager->persist($orderedTestQuestion);
                    $manager->flush();

                    $test->addTestQuestion($orderedTestQuestion);
                }
            }

            $manager->persist($test);
            $manager->flush();
        }

    }
}