<?php

require_once('bbcode.php');

function test($a, $b)
{
  static $test_num = 0;

  $test_num ++;
  echo "Test #", $test_num, ": ";

  try {
    $r = bbcode_to_html($a);

    if ($r !== $b)
    {
      echo "FAILED - items are not equal:\n= A =========\n$r\n= B =========\n$b\n=============\n";
      return 1;
    }
    else
    {
      echo "passed\n";
      return 0;
    }
  } catch (Exception $e) {
    echo 'ERROR - Caught exception: ',  $e->getMessage(), "\n= INPUT =====\n$a\n";
    return 1;
  }
}

// No formatting
test('test', 'test');
// HTML escaping
test('<b>test</b>', '&lt;b&gt;test&lt;/b&gt;');

// Bold text
test('[b]test[/b]', '<b>test</b>');
// Fake tag
test('[spoiler]test[/spoiler]', '[spoiler]test[/spoiler]');
// Escaped bracket
test('[u]To make underlined text, type [[u].[/u]', '<u>To make underlined text, type [u].</u>');
// Preformatted text containing tags
test('Some BBCode tips: [code][u] - underline. [b] - bold.[/code]', 'Some BBCode tips: <pre>[u] - underline. [b] - bold.</pre>');

// URL tests: simple
test('Get the latest php-bbcode release here: [url]https://github.com/greg-kennedy/php-bbcode[/url]', 'Get the latest php-bbcode release here: <a href="https://github.com/greg-kennedy/php-bbcode">https://github.com/greg-kennedy/php-bbcode</a>');
// URL tests: complex
test('Get the latest php-bbcode release [url=https://github.com/greg-kennedy/php-bbcode]here[/url].', 'Get the latest php-bbcode release <a href="https://github.com/greg-kennedy/php-bbcode">here</a>.');


// Unclosed tag
test('[b]test', '<b>test</b>');
// Unterminated tag
test('[btest', '[btest');
// Unordered tag
test('Here is [b]bold and [i]italics[/b][/i] text.', 'Here is <b>bold and <i>italics</i></b>[/i] text.');
// Mismatched aliased tag
test('A wise man once said: [quote]Do not parse HTML with a regex.[/blockquote] I think he was on to something.', 'A wise man once said: <blockquote>Do not parse HTML with a regex.</blockquote> I think he was on to something.');
// td outside tr
test('[table][tr][th]Name[/th][th]Phone[/th][/tr][td]Greg[/td][td]555-1212[/td][/table]','<table><tr><th>Name</th><th>Phone</th></tr>[td]Greg[/td][td]555-1212[/td]</table>');

?>
