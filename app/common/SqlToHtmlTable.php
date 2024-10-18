<?php

namespace app\common;
class SqlToHtmlTable
{

    public function generateTable($data): string
    {
        if (empty($data)) {
            return '<p>No data available</p>';
        }

        $html = '<table border="1" cellpadding="5" cellspacing="0">';

        // Генеруємо заголовки таблиці на основі ключів першого елемента масиву
        $html .= '<thead><tr>';
        foreach (array_keys($data[0]) as $header) {
            $html .= '<th>' . htmlspecialchars($header) . '</th>';
        }
        $html .= '</tr></thead>';

        // Генеруємо рядки з даними
        $html .= '<tbody>';
        foreach ($data as $row) {
            $html .= '<tr>';
            foreach ($row as $value) {
                $html .= '<td>' . htmlspecialchars($value) . '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody>';

        $html .= '</table>';

        return $html;
    }
}
