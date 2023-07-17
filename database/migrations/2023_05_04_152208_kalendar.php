<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Kalendar extends Migration{
    public function up(){
        Schema::create('kalendar', function (Blueprint $table) {
            $table->id();
            $table->string('deal_id')->nullable();
            $table->string('deal_into_id')->nullable();
            $table->text('name_and_number')->nullable(); ///*/ Название сделки, внутренний номер ///*/ 
            $table->text('parties_to_case')->nullable(); ///*/ Стороны по делу ///*/ 
            $table->text('who_represent')->nullable(); ///*/ Кого представляем ///*/ 
            $table->text('subject_dispute')->nullable(); ///*/ Предмет спора ///*/ 
            $table->text('deposit')->nullable(); ///*/ Залог ///*/ 
            //$table->text('strategy')->nullable(); ///*/ Стратегия ///*/
            //$table->text('claim')->nullable(); ///*/ Претензия ///*/
            //$table->integer('claim_price')->nullable(); ///*/ Цена иска ///*/
            //$table->integer('state_duty')->nullable(); ///*/ Госпошлина ///*/
            $table->string('date_start')->nullable(); ///*/ Дата начала дела ///*/ 
            $table->text('number_case')->nullable(); ///*/ Номер дела в суде первой инстанции ///*/ 
            $table->text('court_judge')->nullable(); ///*/ Суд, Судья ///*/ 
            $table->text('link')->nullable(); ///*/ Ссылка на дело на сайте суда ///*/ 
            //$table->text('information_progress')->nullable(); ///*/ Информация о ходе дела ///*/
            //$table->timestamp('date_upcoming_case')->nullable(); ///*/ Дата предстоящего судебного заседания ///*/
            $table->text('information_case')->nullable(); ///*/ Информация о наложении обеспечительных мер ///*/
            //$table->text('current_state_case')->nullable(); ///*/ Текущее состояние дела ///*/ 
            $table->text('result_case')->nullable(); ///*/ Результат рассмотрения дела ///*/ 
            $table->integer('sum_case')->nullable(); ///*/ Сумма заявленных требований и удовлетворенных судом ///*/ 
            $table->string('date_force_case')->nullable(); ///*/ Дата вступления судебного акта в законную силу ///*/ 
            $table->text('time_limit')->nullable(); ///*/ Срок на обжалование ///*/ 
            $table->string('date_production_case')->nullable(); ///*/ Дата фактического изготовления судом решения ///*/ 
            $table->string('date_receipt_case')->nullable(); ///*/ Дата получения решения ///*/ 
            $table->text('appeal_case')->nullable(); ///*/ Сведения о необходимости обжалования судебного акта ///*/ 
            $table->string('date_filing_appeal')->nullable(); ///*/ Дата подачи жалобы ///*/ 
            $table->string('date_acceptance_appeal')->nullable(); ///*/ Дата принятия жалобы ///*/ 
            $table->integer('sum_services')->nullable(); ///*/ Сумма оказанных юридических услуг ///*/ 
            
            $table->string('created_at')->nullable();
            $table->string('updated_at')->nullable();
            $table->string('deleted_at')->nullable();
        });
    }
    public function down(){Schema::dropIfExists('kalendar');}
}
