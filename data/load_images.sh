#!/bin/bash

DIR="$1"

separator=" "
sql="INSERT INTO \`wp_posts\` (\`post_author\`, \`post_date\`, \`post_date_gmt\`,
                             \`post_content\`, \`post_title\`, \`post_excerpt\`, \`post_status\`,
                             \`comment_status\`, \`ping_status\`, \`post_password\`, \`post_name\`,
                             \`to_ping\`, \`pinged\`, \`post_modified\`, \`post_modified_gmt\`,
                             \`post_content_filtered\`, \`post_parent\`, \`guid\`, \`menu_order\`,
                             \`post_type\`, \`post_mime_type\`, \`comment_count\`) VALUES
"
for filepath in $DIR/*.jpg;
do
    filename=`basename $filepath`
    img_name="${filename:0:-4}"
    lower_name=`tr '[:upper:]' '[:lower:]' <<< $img_name`

    sql="$sql
        $separator(1, '2014-10-26 23:59:59', '2014-10-26 23:59:59', '',
                '$img_name', '', 'inherit', 'open', 'open', '',
                '$lower_name', '', '', '2014-10-26 23:59:59', '2014-10-26 23:59:59', '', 0,
                'http://cartinhas.dev/wp-content/uploads/2014/10/$img_name.jpg', 0,
                'attachment', 'image/jpeg', 0)"
    separator=","
done

# -- INSERE CARTINHAS
#
# INSERT INTO `wp_posts` (`post_author`, `post_date`, `post_date_gmt`,
#                         `post_content`, `post_title`, `post_excerpt`, `post_status`,
#                         `comment_status`,`ping_status`, `post_password`, `post_name`,
#                         `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`,
#                         `post_content_filtered`, `post_parent`, `guid`, `menu_order`,
#                         `post_type`, `post_mime_type`, `comment_count`)
#
#     SELECT 1, '2014-10-26 08:52:55', '2014-10-26 11:52:55', '', p.post_title, '',
#         'publish', 'closed', 'closed', '', p.post_name, '', '', '2014-10-26 15:44:07',
#         '2014-10-26 18:44:07', '', 0, '',  0, 'cartinha', '', 0 FROM `wp_posts` p
#         WHERE post_date='2014-10-26 23:59:59' and post_type='attachment'


# -- FAZ VINCULOS ENTRE MEDIA E CARTINHA
#
# UPDATE wp_posts a JOIN wp_posts c ON c.post_title = a.post_title
# SET a.post_parent=c.ID WHERE c.post_type='cartinha' AND a.post_type='attachment';




echo $sql
