<?php

// database/migrations/xxxx_xx_xx_xxxxxx_add_numeros_asiento_to_reservaciones_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservaciones', function (Blueprint $table) {
            // Añadimos la columna para guardar los asientos como JSON
            // Se guardará un array como: ["1A", "1B", "4C"]
            $table->json('numeros_asiento')->nullable()->after('vuelo_id');

            // Hacemos que la columna 'asientos' sea opcional o la eliminamos
            // si ya no la necesitas, ya que podemos calcular la cantidad desde el JSON.
            // Por ahora, la mantenemos para compatibilidad.
        });
    }

    public function down(): void
    {
        Schema::table('reservaciones', function (Blueprint $table) {
            $table->dropColumn('numeros_asiento');
        });
    }
};