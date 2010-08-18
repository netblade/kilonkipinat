// 2DO: Add l10n strings

/* This is an example article, taken from the de.linkm.taviewer default
 * schema.
 *
 * When overriding this schema database with component specific data using
 * a snippet that is usually put into the snippetdir 
 * /sitegroup-config/fi.kilonkipinat.forms/
 * and configured using the configuration key "schemadb" all fields that are
 * within the component required section must be copied verbatim (you may
 * change the description field though).
 */
'default' => array
(
    'description' => 'article',
    'fields'      => array
    (
        'name' => Array
        (
            // COMPONENT-REQUIRED
            'title' => 'url name',
            'storage' => 'name',
            'type' => 'urlname',
            'widget' => 'text',
        ),
        'title' => Array
        (
            // COMPONENT-REQUIRED
            'title' => 'title',
            'storage' => 'title',
            'required' => true,
            'type' => 'text',
            'widget' => 'text',
        ),
        'content' => Array
        (
            // COMPONENT-REQUIRED
            'title' => 'content',
            'storage' => 'content',
            'required' => true,
            'type' => 'text',
            'type_config' => array
            (
                'output_mode' => 'html'
            ),
            'widget' => 'tinymce',
        ),
    ),
),

