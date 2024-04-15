
    <?php
    // 西暦 => 和暦
    function wareki($year)
    {

        $eras = array(
            array('year' => 2018, 'name' => '令和'),
            array('year' => 1988, 'name' => '平成'),
            array('year' => 1925, 'name' => '昭和'),
            array('year' => 1911, 'name' => '大正'),
            array('year' => 1867, 'name' => '明治')
        );

        foreach ($eras as $era) {

            $base_year = $era['year'];
            $era_name = $era['name'];

            if ($year > $base_year) {

                $era_year = $year - $base_year;

                if ($era_year === 1) {
                    return $era_name . '元年';
                }

                return $era_name . $era_year . '年';
            }
        }
        return null;
    }
    ?>