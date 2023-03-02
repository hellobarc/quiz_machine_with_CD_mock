<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\ListeningController;
use App\Http\Controllers\Admin\Mock\ManageMockController;
use App\Http\Controllers\Admin\Mock\MockExerciseController;
use App\Http\Controllers\Admin\Mock\MockQuestionController;
use App\Http\Controllers\Admin\Mock\MockPassageController;
use App\Http\Controllers\Admin\Mock\MockAddQuestionController;
use App\Http\Controllers\Admin\Mock\MockAudioController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\LevelTestController;
use App\Http\Controllers\Frontend\Mock\MockModuleController;
use App\Http\Controllers\Frontend\User\UserAuthenticationController;
use App\Http\Controllers\Frontend\User\DashboardController;
use App\Http\Controllers\Frontend\User\SubmittedMockController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes(['register' => false]);

// Route::get('/', function () {
//     return view('welcome');
// });

//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/admin_dashboard', [App\Http\Controllers\HomeController::class, 'dashboard']);
// 'middleware' => 'api',
Route::group(['prefix'=> 'admin'], function ($routes) {
    Route::get('/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/logout', [AdminController::class, 'adminLogout'])->name('admin.logout');
    // users routes
    Route::get('/users', [AdminController::class, 'allUser'])->name('admin.users');
    //admin level routes
    Route::get('/level', [LevelController::class, 'level'])->name('admin.settings.level');
    Route::get('/level/create', [LevelController::class, 'createLevel'])->name('admin.settings.level.create');
    Route::post('/level/store', [LevelController::class, 'storeLevel'])->name('admin.settings.level.store');
    Route::get('/level/show/{id}', [LevelController::class, 'editLevel'])->name('admin.settings.level.edit');
    Route::post('/level/update/{id}', [LevelController::class, 'updateLevel'])->name('admin.settings.level.update');
    Route::get('/level/delete/{id}', [LevelController::class, 'deleteLevel'])->name('admin.settings.level.delete');
    //admin category routes
    Route::get('/category', [CategoryController::class, 'category'])->name('admin.settings.category');
    Route::get('/category/create', [CategoryController::class, 'createCategory'])->name('admin.settings.category.create');
    Route::post('/category/store', [CategoryController::class, 'storeCategory'])->name('admin.settings.category.store');
    Route::get('/category/show/{id}', [CategoryController::class, 'editCategory'])->name('admin.settings.category.edit');
    Route::post('/category/update/{id}', [CategoryController::class, 'updateCategory'])->name('admin.settings.category.update');
    Route::get('/category/delete/{id}', [CategoryController::class, 'deleteCategory'])->name('admin.settings.category.delete');
    //admin exam routes
    Route::get('/exam', [ExamController::class, 'exam'])->name('admin.settings.exam');
    Route::get('/exam/create', [ExamController::class, 'createExam'])->name('admin.settings.exam.create');
    Route::post('/exam/store', [ExamController::class, 'storeExam'])->name('admin.settings.exam.store');
    Route::get('/exam/show/{id}', [ExamController::class, 'editExam'])->name('admin.settings.exam.edit');
    Route::post('/exam/update/{id}', [ExamController::class, 'updateExam'])->name('admin.settings.exam.update');
    Route::get('/exam/delete/{id}', [ExamController::class, 'deleteExam'])->name('admin.settings.exam.delete');
    //admin quiz routes
    Route::get('/quiz', [QuizController::class, 'quiz'])->name('admin.settings.quiz');
    Route::get('/quiz/create', [QuizController::class, 'createQuiz'])->name('admin.settings.quiz.create');
    Route::post('/quiz/store', [QuizController::class, 'storeQuiz'])->name('admin.settings.quiz.store');
    Route::get('/quiz/show/{id}', [QuizController::class, 'editQuiz'])->name('admin.settings.quiz.edit');
    Route::post('/quiz/update/{id}', [QuizController::class, 'updateQuiz'])->name('admin.settings.quiz.update');
    Route::get('/quiz/delete/{templete}/{quizType}/{id}', [QuizController::class, 'deleteQuiz'])->name('admin.settings.quiz.delete');
    //admin add quizzes
    Route::get('/add-question/{quizType}/{quizId}', [QuestionController::class, 'addQuestion'])->name('admin.settings.quiz.add-question');
    Route::post('/store-question/fill-blanks', [QuestionController::class, 'storeFillBlank'])->name('admin.settings.quiz.fill-blank.store-question');
    Route::get('/delete-question/fill-blanks/{id}', [QuestionController::class, 'deleteFillBlank'])->name('admin.settings.quiz.fill-blank.delete-question');
    Route::post('/store-question/multiple-choice', [QuestionController::class, 'storeMultipleChoice'])->name('admin.settings.quiz.multiple-choice.store-question');
    Route::get('/delete-question/multiple-choice/{id}/{quizType}', [QuestionController::class, 'deleteMultipleChoice'])->name('admin.settings.quiz.multiple-choice.delete-question');
    //admin article
    Route::get('/article/{quizType}/{quizId}', [ArticleController::class, 'article'])->name('admin.settings.quiz.article');
    Route::post('/article/store', [ArticleController::class, 'articleStore'])->name('admin.settings.quiz.store-article');
    Route::get('/article/delelete/perm/{id}',  [ArticleController::class, 'articleDelete'])->name('admin.settings.quiz.delete-article');
    //admin listening
    Route::get('/listening/{quizId}', [ListeningController::class, 'listening'])->name('admin.settings.quiz.listening');
    Route::post('/listening/store', [ListeningController::class, 'listeningStore'])->name('admin.settings.quiz.store-listening');
    Route::get('/listening/delelete/perm/{id}',  [ListeningController::class, 'listeningDelete'])->name('admin.settings.quiz.delete-listening');
    Route::get('/quiz/fillBlank/box/{quizId}/{quizType}',  [QuestionController::class, 'showOptionBox'])->name('admin.settings.quiz.show.box');
    Route::post('/quiz/fillBlank/box/add',  [QuestionController::class, 'showOptionBoxUpdate'])->name('admin.settings.quiz.update.box');
    // CD Mock route
    Route::group(['prefix'=> 'mock'], function ($routes) {
        //manage mock
        Route::get('/', [ManageMockController::class, 'mock'])->name('admin.settings.mock');
        Route::get('/create', [ManageMockController::class, 'createMock'])->name('admin.settings.mock.create');
        Route::post('/store', [ManageMockController::class, 'storeMock'])->name('admin.settings.mock.store');
        Route::get('/show/{id}', [ManageMockController::class, 'editMock'])->name('admin.settings.mock.edit');
        Route::post('/update/{id}', [ManageMockController::class, 'updateMock'])->name('admin.settings.mock.update');
        Route::get('/delete/{id}', [ManageMockController::class, 'deleteMock'])->name('admin.settings.Mock.delete');
        //mock exercise route
        Route::get('/exercise', [MockExerciseController::class, 'mockExercise'])->name('admin.settings.mock.exercise');
        Route::get('/exercise/create', [MockExerciseController::class, 'createMockExercise'])->name('admin.settings.mock.exercise.create');
        Route::post('/exercise/store', [MockExerciseController::class, 'storeMockExercise'])->name('admin.settings.mock.exercise.store');
        Route::get('/exercise/delete/{id}', [MockExerciseController::class, 'deleteMockExercise'])->name('admin.settings.mock.exercise.delete');
        //mock questions route
        Route::get('/questions', [MockQuestionController::class, 'mockQuestions'])->name('admin.settings.mock.questions');
        Route::get('/question/create', [MockQuestionController::class, 'createMockQuestion'])->name('admin.settings.mock.question.create');
        Route::post('/question/store', [MockQuestionController::class, 'storeMockQuestion'])->name('admin.settings.mock.question.store');
        Route::get('/question/show/{id}', [MockQuestionController::class, 'editMockQuestion'])->name('admin.settings.mock.question.edit');
        Route::post('/question/update/{id}', [MockQuestionController::class, 'updateMockQuestion'])->name('admin.settings.mock.question.update');
        Route::get('/question/delete/{id}/{questionType}', [MockQuestionController::class, 'deleteMockQuestion'])->name('admin.settings.mock.question.delete');
        //mock add questions route
        Route::get('/add-question/{questionType}/{questionId}', [MockAddQuestionController::class, 'addQuestion'])->name('admin.settings.mock.add-question');
        Route::post('/store-question/multiple-choice', [MockAddQuestionController::class, 'storeQuestSub'])->name('admin.settings.mock.multiple-choice.store-question');
        Route::get('/delete-question/multiple-choice/{id}/{questionType}', [MockAddQuestionController::class, 'deleteQuestSub'])->name('admin.settings.mock.multiple-choice.delete-question');
        Route::post('/store-question/fill-blanks', [MockAddQuestionController::class, 'storeQuestSubFillBlank'])->name('admin.settings.mock.fill-blank.store-question');
        Route::get('/delete-question/fill-blanks/{id}', [MockAddQuestionController::class, 'deleteQuestSubFillBlank'])->name('admin.settings.mock.fill-blank.delete-question');
        Route::post('/store-question/heading-match', [MockAddQuestionController::class, 'storeQuestSubheadingmatch'])->name('admin.settings.mock.heading-match.store-question');
        Route::get('/delete-question/heading-match/{id}', [MockAddQuestionController::class, 'deleteQuestSubHeadingMatch'])->name('admin.settings.mock.heading-match.delete-question');
        Route::get('/add-question/heading-match/sub-queston/{question_id}', [MockAddQuestionController::class, 'headingMatchingSubQuestion'])->name('admin.settings.mock.heading-match.sub-question');
        Route::post('/store-question/heading-match/sub-queston', [MockAddQuestionController::class, 'storeHeadingMatchSubQuestion'])->name('admin.settings.mock.heading-match.store.sub-question');
        Route::get('/delete-question/heading-match/sub-queston/{id}', [MockAddQuestionController::class, 'deleteHeadingMatchSubQuestion'])->name('admin.settings.mock.heading-match.delete.sub-question');
        Route::get('/add-question/heading-match/true-of-nice/{question_id}', [MockAddQuestionController::class, 'headingMatchingTrueOfNice'])->name('admin.settings.mock.heading-match.true-of-nice');
        Route::post('/store-question/heading-match/true-of-nice', [MockAddQuestionController::class, 'storeHeadingMatchTrueOfNice'])->name('admin.settings.mock.heading-match.store.true-of-nice');
        Route::get('/delete-question/heading-match/true-of-nice/{id}', [MockAddQuestionController::class, 'deleteHeadingMatchTrueOfNice'])->name('admin.settings.mock.heading-match.delete.true-of-nice');
        
        //mock add passage route
        Route::get('/passage', [MockPassageController::class, 'mockPassage'])->name('admin.settings.mock.passage');
        Route::get('/passage/create', [MockPassageController::class, 'createMockPassage'])->name('admin.settings.mock.passage.create');
        Route::post('/passage/store', [MockPassageController::class, 'storeMockPassage'])->name('admin.settings.mock.passage.store');
        Route::get('/passage/show/{id}', [MockPassageController::class, 'editMockPassage'])->name('admin.settings.mock.passage.edit');
        Route::post('/passage/update/{id}', [MockPassageController::class, 'updateMockPassage'])->name('admin.settings.mock.passage.update');
        Route::get('/passage/delete/{id}', [MockPassageController::class, 'deleteMockPassage'])->name('admin.settings.mock.passage.delete');
        //mock add aduio route
        Route::get('/audio', [MockAudioController::class, 'mockAudio'])->name('admin.settings.mock.audio');
        Route::get('/audio/create', [MockAudioController::class, 'createMockAudio'])->name('admin.settings.mock.audio.create');
        Route::post('/audio/store', [MockAudioController::class, 'storeMockAudio'])->name('admin.settings.mock.audio.store');
        Route::get('/audio/show/{id}', [MockAudioController::class, 'editMockAudio'])->name('admin.settings.mock.audio.edit');
        Route::post('/audio/update/{id}', [MockAudioController::class, 'updateMockAudio'])->name('admin.settings.mock.audio.update');
        Route::get('/audio/delete/{id}', [MockAudioController::class, 'deleteMockAudio'])->name('admin.settings.mock.audio.delete');
    });

});

// frontend routes
Route::get('/', [FrontendController::class, 'frontendHome'])->name('frontend.home');

Route::group(['prefix'=> 'frontend'], function ($routes) {
    Route::get('/exam-info/{test_id}', [FrontendController::class, 'frontendExamInfo'])->name('frontend.exam.info');
    Route::get('/start-exam/{test_id}', [FrontendController::class, 'frontendExamStart'])->name('frontend.exam.start');
    Route::get('/segment-exam/{exam_id}/{segment_id}', [FrontendController::class, 'quizSegement1'])->name('frontend.exam.start');
    Route::get('/start-exam/check/view/{test_id}', [FrontendController::class, 'frontendExamChecked'])->name('frontend.exam.checked');
    Route::post('/start-exam/user-ans', [FrontendController::class, 'frontendExamUserAns'])->name('frontend.exam.user.ans');
    Route::get('/congratulation/{test_id}', [FrontendController::class, 'congratulation'])->name('frontend.exam.congratulation');
    Route::get('/result/{exam_id}', [FrontendController::class, 'result'])->name('frontend.exam.result');
    Route::get('/test', [FrontendController::class, 'test'])->name('frontend.exam.test');
    Route::post('/check-authentication', [FrontendController::class, 'checkAuthentication'])->name('frontend.check.authentication');
    Route::get('/user-dashboard', [FrontendController::class, 'userDashboard'])->name('frontend.user.dashboard');
    Route::get('/exam-show', [FrontendController::class, 'frontendJsonExam'])->name('frontend.exam.show');
    Route::get('/exam-search', [FrontendController::class, 'frontendJsonSearch'])->name('frontend.exam.search');
    Route::get('/level-test', [LevelTestController::class, 'levelTest'])->name('level.test');
    Route::get('/level-test/adult', [LevelTestController::class, 'levelTestAdult'])->name('level.test.adult');
    Route::get('/user/authentication/{exam_id?}', [UserAuthenticationController::class, 'userAuthentication'])->name('frontend.user.authentication');

    Route::group(['prefix'=> 'mock'], function ($routes) {
        Route::get('/module-info/{mock_id}', [MockModuleController::class, 'moduleInfo'])->name('frontend.mock.module.info');
        Route::get('/mock-authentication/{mock_id}', [MockModuleController::class, 'mockAuthentication'])->name('frontend.mock.authentication');
        Route::get('/module/instruction/{mock_id}/{module_id}', [MockModuleController::class, 'mockModuleInstruction'])->name('frontend.mock.module.instruction');
        Route::get('/module/{mock_id}/{module_id}/{segment_id}', [MockModuleController::class, 'mockModule'])->name('frontend.mock.module');
        Route::post('/module/submission', [MockModuleController::class, 'mockModuleSubmission'])->name('frontend.mock.module.submission');
        Route::get('/reading/module/result/{mock_id}/{module_id}', [MockModuleController::class, 'mockModuleResult'])->name('frontend.mock.module.result');
        Route::get('/module/review/{mock_id}/{module_id}/{segment_id}', [MockModuleController::class, 'mockModuleReview'])->name('frontend.mock.module.review');
        Route::get('/category', [MockModuleController::class, 'mockCategory'])->name('frontend.mock.category');
        Route::get('/test', [MockModuleController::class, 'test'])->name('frontend.mock.test');
        
    });
    Route::group(['prefix'=> 'user'], function ($routes) {
        Route::post('/login', [UserAuthenticationController::class, 'login'])->name('frontend.user.login');
        Route::post('/regitster', [UserAuthenticationController::class, 'register'])->name('frontend.user.register');
        Route::get('/logout', [UserAuthenticationController::class, 'logout'])->name('frontend.user.logout');
        Route::get('/dashboard', [DashboardController::class, 'userDashboard'])->name('frontend.user.dashboard');
        Route::group(['prefix'=> 'mock'], function ($routes) {
            Route::get('/module-info/{mock_id}', [SubmittedMockController::class, 'moduleInfo'])->name('frontend.user.mock.module.info');
        });
    });
});

