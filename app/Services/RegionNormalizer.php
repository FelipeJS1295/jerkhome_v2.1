<?php

namespace App\Services;

class RegionNormalizer
{
    private const REGIONES = [
        'XV' => ['Arica', 'Arica y Parinacota', '15', 'XV', 'Región XV'],
        'I' => ['Tarapacá', 'Iquique', '1', 'I', 'Primera', 'Región I'],
        'II' => ['Antofagasta', '2', 'II', 'Segunda', 'Región II'],
        'III' => ['Atacama', 'Copiapó', '3', 'III', 'Tercera', 'Región III'],
        'IV' => ['Coquimbo', 'La Serena', '4', 'IV', 'Cuarta', 'Región IV'],
        'V' => ['Valparaíso', 'Viña del Mar', '5', 'V', 'Quinta', 'Región V'],
        'RM' => ['Metropolitana', 'Santiago', 'RM', 'R.M.', 'Region Metropolitana', '13', 'XIII'],
        'VI' => ['OHiggins', "O'Higgins", 'Rancagua', '6', 'VI', 'Sexta', 'Región VI'],
        'VII' => ['Maule', 'Talca', '7', 'VII', 'Séptima', 'Región VII'],
        'XVI' => ['Ñuble', 'Chillán', '16', 'XVI', 'Región XVI'],
        'VIII' => ['Biobío', 'Bio-Bio', 'Concepción', '8', 'VIII', 'Octava', 'Región VIII'],
        'IX' => ['Araucanía', 'Temuco', '9', 'IX', 'Novena', 'Región IX'],
        'XIV' => ['Los Ríos', 'Valdivia', '14', 'XIV', 'Región XIV'],
        'X' => ['Los Lagos', 'Puerto Montt', '10', 'X', 'Décima', 'Región X'],
        'XI' => ['Aysén', 'Aysen', 'Coyhaique', '11', 'XI', 'Región XI'],
        'XII' => ['Magallanes', 'Punta Arenas', '12', 'XII', 'Región XII']
    ];

    private const COMUNAS_POR_REGION = [
        'XV' => ['Arica', 'Camarones', 'Putre', 'General Lagos'],
        'I' => ['Iquique', 'Alto Hospicio', 'Pozo Almonte', 'Camiña', 'Colchane', 'Huara', 'Pica'],
        'II' => ['Antofagasta', 'Calama', 'María Elena', 'Mejillones', 'Ollagüe', 'San Pedro de Atacama', 'Sierra Gorda', 'Taltal', 'Tocopilla'],
        'III' => ['Copiapó', 'Caldera', 'Tierra Amarilla', 'Chañaral', 'Diego de Almagro', 'Vallenar', 'Alto del Carmen', 'Freirina', 'Huasco'],
        'IV' => ['La Serena', 'Coquimbo', 'Andacollo', 'La Higuera', 'Paiguano', 'Vicuña', 'Illapel', 'Canela', 'Los Vilos', 'Salamanca', 'Ovalle', 'Combarbalá', 'Monte Patria', 'Punitaqui', 'Río Hurtado'],
        'V' => ['Valparaíso', 'Casablanca', 'Concón', 'Juan Fernández', 'Puchuncaví', 'Quintero', 'Viña del Mar', 'Isla de Pascua', 'Los Andes', 'Calle Larga', 'Rinconada', 'San Esteban', 'La Ligua', 'Cabildo', 'Papudo', 'Petorca', 'Zapallar', 'Quillota', 'Calera', 'Hijuelas', 'La Cruz', 'Nogales', 'San Antonio', 'Algarrobo', 'Cartagena', 'El Quisco', 'El Tabo', 'Santo Domingo', 'San Felipe', 'Catemu', 'Llaillay', 'Panquehue', 'Putaendo', 'Santa María', 'Quilpué', 'Limache', 'Olmué', 'Villa Alemana'],
        'RM' => ['Santiago', 'Cerrillos', 'Cerro Navia', 'Conchalí', 'El Bosque', 'Estación Central', 'Huechuraba', 'Independencia', 'La Cisterna', 'La Florida', 'La Granja', 'La Pintana', 'La Reina', 'Las Condes', 'Lo Barnechea', 'Lo Espejo', 'Lo Prado', 'Macul', 'Maipú', 'Ñuñoa', 'Pedro Aguirre Cerda', 'Peñalolén', 'Providencia', 'Pudahuel', 'Quilicura', 'Quinta Normal', 'Recoleta', 'Renca', 'San Joaquín', 'San Miguel', 'San Ramón', 'Vitacura', 'Puente Alto', 'Pirque', 'San José de Maipo', 'Colina', 'Lampa', 'Tiltil', 'San Bernardo', 'Buin', 'Calera de Tango', 'Paine', 'Melipilla', 'Alhué', 'Curacaví', 'María Pinto', 'San Pedro', 'Talagante', 'El Monte', 'Isla de Maipo', 'Padre Hurtado', 'Peñaflor'],
        'VI' => ['Rancagua', 'Codegua', 'Coinco', 'Coltauco', 'Doñihue', 'Graneros', 'Las Cabras', 'Machalí', 'Malloa', 'Mostazal', 'Olivar', 'Peumo', 'Pichidegua', 'Quinta de Tilcoco', 'Rengo', 'Requínoa', 'San Vicente', 'Pichilemu', 'La Estrella', 'Litueche', 'Marchihue', 'Navidad', 'Paredones', 'San Fernando', 'Chépica', 'Chimbarongo', 'Lolol', 'Nancagua', 'Palmilla', 'Peralillo', 'Placilla', 'Pumanque', 'Santa Cruz'],
        'VII' => ['Talca', 'Constitución', 'Curepto', 'Empedrado', 'Maule', 'Pelarco', 'Pencahue', 'Río Claro', 'San Clemente', 'San Rafael', 'Cauquenes', 'Chanco', 'Pelluhue', 'Curicó', 'Hualañé', 'Licantén', 'Molina', 'Rauco', 'Romeral', 'Sagrada Familia', 'Teno', 'Vichuquén', 'Linares', 'Colbún', 'Longaví', 'Parral', 'Retiro', 'San Javier', 'Villa Alegre', 'Yerbas Buenas'],
        'XVI' => ['Chillán', 'Bulnes', 'Cobquecura', 'Coelemu', 'Coihueco', 'Chillán Viejo', 'El Carmen', 'Ninhue', 'Ñiquén', 'Pemuco', 'Pinto', 'Portezuelo', 'Quillón', 'Quirihue', 'Ránquil', 'San Carlos', 'San Fabián', 'San Ignacio', 'San Nicolás', 'Treguaco', 'Yungay'],
        'VIII' => ['Concepción', 'Coronel', 'Chiguayante', 'Florida', 'Hualqui', 'Lota', 'Penco', 'San Pedro de la Paz', 'Santa Juana', 'Talcahuano', 'Tomé', 'Hualpén', 'Lebu', 'Arauco', 'Cañete', 'Contulmo', 'Curanilahue', 'Los Álamos', 'Tirúa', 'Los Ángeles', 'Antuco', 'Cabrero', 'Laja', 'Mulchén', 'Nacimiento', 'Negrete', 'Quilaco', 'Quilleco', 'San Rosendo', 'Santa Bárbara', 'Tucapel', 'Yumbel', 'Alto Biobío'],
        'IX' => ['Temuco', 'Carahue', 'Cunco', 'Curarrehue', 'Freire', 'Galvarino', 'Gorbea', 'Lautaro', 'Loncoche', 'Melipeuco', 'Nueva Imperial', 'Padre las Casas', 'Perquenco', 'Pitrufquén', 'Pucón', 'Saavedra', 'Teodoro Schmidt', 'Toltén', 'Vilcún', 'Villarrica', 'Cholchol', 'Angol', 'Collipulli', 'Curacautín', 'Ercilla', 'Lonquimay', 'Los Sauces', 'Lumaco', 'Purén', 'Renaico', 'Traiguén', 'Victoria'],
        'XIV' => ['Valdivia', 'Corral', 'Lanco', 'Los Lagos', 'Máfil', 'Mariquina', 'Paillaco', 'Panguipulli', 'La Unión', 'Futrono', 'Lago Ranco', 'Río Bueno'],
        'X' => ['Puerto Montt', 'Calbuco', 'Cochamó', 'Fresia', 'Frutillar', 'Los Muermos', 'Llanquihue', 'Maullín', 'Puerto Varas', 'Castro', 'Ancud', 'Chonchi', 'Curaco de Vélez', 'Dalcahue', 'Puqueldón', 'Queilén', 'Quellón', 'Quemchi', 'Quinchao', 'Osorno', 'Puerto Octay', 'Purranque', 'Puyehue', 'Río Negro', 'San Juan de la Costa', 'San Pablo', 'Chaitén', 'Futaleufú', 'Hualaihué', 'Palena'],
        'XI' => ['Coyhaique', 'Lago Verde', 'Aysén', 'Cisnes', 'Guaitecas', 'Cochrane', 'O Higgins', 'Tortel', 'Chile Chico', 'Río Ibáñez'],
        'XII' => ['Punta Arenas', 'Laguna Blanca', 'Río Verde', 'San Gregorio', 'Cabo de Hornos', 'Antártica', 'Porvenir', 'Primavera', 'Timaukel', 'Natales', 'Torres del Paine']
    ];

    private const ALIASES_REGIONES = [
        'RM' => ['Metropolitana', 'Region Metropolitana', 'Santiago', 'Metropolitana de Santiago', 'R.M.', '13'],
        'V' => ['Valparaiso', 'viña del mar', 'V Región'],
        'VIII' => ['BIO BIO', 'BIOBIO', 'Región del Bio Bio', 'Biobío', 'Bíobío', 'Concepción'],
        'X' => ['LOS LAGOS', 'Puerto Montt'],
        'VI' => ['LIBERTADOR GENERAL BERNARDO O\'HIGGINS', "O'Higgins", 'Rancagua', 'O\'Higgins'],
        'III' => ['ATACAMA', 'Copiapó'],
        'IX' => ['LA ARAUCANIA', 'Araucanía', 'Araucania', 'Temuco'],
        'XV' => ['ARICA Y PARINACOTA', 'Arica'],
        'XII' => ['MAGALLANES Y LA ANTARTICA CHILENA', 'Magallanes', 'Punta Arenas'],
        'I' => ['TARAPACA', 'Iquique'],
        'XVI' => ['Ñuble', 'Nuble', 'Chillán'],
        'XI' => ['AYSEN DEL GENERAL CARLOS IBAÑEZ DEL CAMPO', 'Aysén', 'Aysen', 'Coyhaique'],
    ];

    public function normalize($input) 
    {
        $input = $this->limpiarTexto($input);
        
        // Buscar en aliases
        foreach (self::ALIASES_REGIONES as $codigo => $aliases) {
            if (in_array($input, array_map([$this, 'limpiarTexto'], $aliases))) {
                return $codigo;
            }
        }
        
        // Buscar en regiones principales
        foreach (self::REGIONES as $codigo => $alternativas) {
            if (in_array($input, array_map([$this, 'limpiarTexto'], $alternativas))) {
                return $codigo;
            }
        }
    
        // Buscar por comuna
        foreach (self::COMUNAS_POR_REGION as $codigo => $comunas) {
            if (in_array($input, array_map([$this, 'limpiarTexto'], $comunas))) {
                return $codigo;
            }
        }
    
        // Si no se encuentra, usar búsqueda aproximada
        return $this->busquedaAproximada($input);
    }

    private function limpiarTexto($texto) 
    {
        $texto = strtolower($texto);
        $texto = preg_replace('/[áàãâä]/ui', 'a', $texto);
        $texto = preg_replace('/[éèêë]/ui', 'e', $texto);
        $texto = preg_replace('/[íìîï]/ui', 'i', $texto);
        $texto = preg_replace('/[óòõôö]/ui', 'o', $texto);
        $texto = preg_replace('/[úùûü]/ui', 'u', $texto);
        $texto = preg_replace('/[ñ]/ui', 'n', $texto);
        $texto = preg_replace('/[^a-z0-9]/i', '', $texto);
        return $texto;
    }

    private function busquedaAproximada($input)
    {
        $mejorCoincidencia = null;
        $mejorPuntaje = 0;

        foreach (self::REGIONES as $codigo => $alternativas) {
            foreach ($alternativas as $alternativa) {
                $puntaje = similar_text(
                    $this->limpiarTexto($input),
                    $this->limpiarTexto($alternativa),
                    $porcentaje
                );
                
                if ($porcentaje > $mejorPuntaje) {
                    $mejorPuntaje = $porcentaje;
                    $mejorCoincidencia = $codigo;
                }
            }
        }

        return $mejorPuntaje > 80 ? $mejorCoincidencia : 'NO_IDENTIFICADA';
    }
}