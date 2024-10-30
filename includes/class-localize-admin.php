<?php
if ( !class_exists('Localize_Admin')) {
    class Localize_Admin
    {

        public function localize_plugin_menu() {
            $icon_svg = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+Cjxzdmcgd2lkdGg9IjE2MHB4IiBoZWlnaHQ9IjE2MHB4IiB2aWV3Qm94PSIwIDAgMTYwIDE2MCIgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4bWxuczpza2V0Y2g9Imh0dHA6Ly93d3cuYm9oZW1pYW5jb2RpbmcuY29tL3NrZXRjaC9ucyI+CiAgICA8IS0tIEdlbmVyYXRvcjogU2tldGNoIDMuMy4zICgxMjA4MSkgLSBodHRwOi8vd3d3LmJvaGVtaWFuY29kaW5nLmNvbS9za2V0Y2ggLS0+CiAgICA8dGl0bGU+SWNvbjwvdGl0bGU+CiAgICA8ZGVzYz5DcmVhdGVkIHdpdGggU2tldGNoLjwvZGVzYz4KICAgIDxkZWZzPjwvZGVmcz4KICAgIDxnIGlkPSJMb2NhbGl6ZS1VSS1FbGVtZW50cyIgc3Ryb2tlPSJub25lIiBzdHJva2Utd2lkdGg9IjEiIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCIgc2tldGNoOnR5cGU9Ik1TUGFnZSI+CiAgICAgICAgPGcgaWQ9Ikljb24iIHNrZXRjaDp0eXBlPSJNU0FydGJvYXJkR3JvdXAiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDE2LjAwMDAwMCwgMTYuMDAwMDAwKSIgc3Ryb2tlPSIjRkZGRkZGIiBzdHJva2Utb3BhY2l0eT0iMCIgc3Ryb2tlLXdpZHRoPSI1IiBmaWxsPSIjMjQ2Q0EwIj4KICAgICAgICAgICAgPHBhdGggZD0iTTY0LDEwMCBDODMuODgyMjUxLDEwMCAxMDAsODMuODgyMjUxIDEwMCw2NCBDMTAwLDQ0LjExNzc0OSA4My44ODIyNTEsMjggNjQsMjggQzQ0LjExNzc0OSwyOCAyOCw0NC4xMTc3NDkgMjgsNjQgQzI4LDgzLjg4MjI1MSA0NC4xMTc3NDksMTAwIDY0LDEwMCBaIE02NCwxMjAgQzk0LjkyNzk0NiwxMjAgMTIwLDk0LjkyNzk0NiAxMjAsNjQgQzEyMCwzMy4wNzIwNTQgOTQuOTI3OTQ2LDggNjQsOCBDMzMuMDcyMDU0LDggOCwzMy4wNzIwNTQgOCw2NCBDOCw5NC45Mjc5NDYgMzMuMDcyMDU0LDEyMCA2NCwxMjAgWiIgaWQ9Ik92YWwiIHNrZXRjaDp0eXBlPSJNU1NoYXBlR3JvdXAiPjwvcGF0aD4KICAgICAgICA8L2c+CiAgICA8L2c+Cjwvc3ZnPg==';
            add_menu_page(
                'Localize',
                'Localize',
                'administrator',
                plugin_dir_path(__DIR__) . 'admin/view.php',
                null, // no function needed since we link to admin settings page
                $icon_svg);
        }

    }
}