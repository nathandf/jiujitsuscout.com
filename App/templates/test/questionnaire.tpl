
{foreach from=$questionnaire->questions item=question}
	<h2>{$question->text}</h2>

	<ul>
		{foreach from=$question->question_choices item=choice}
			<h3>{$choice->text}</h3>
		{/foreach}
	</ul>
{/foreach}
