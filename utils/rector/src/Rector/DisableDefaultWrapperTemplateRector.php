<?php

declare(strict_types=1);

namespace Creode\Blocks\Utils\Rector;

use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Return_;
use Rector\Rector\AbstractRector;
use PhpParser\Node\Stmt\ClassMethod;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;

/**
 * Rector rule to add use_default_wrapper_template() method to all Creode_Blocks\Block classes.
 *
 * This rule adds a protected method that returns false to all classes that extend
 * Creode_Blocks\Block. The method is used to determine if the block should use
 * the default wrapper template.
 *
 * @see \Creode_Blocks\Block
 */
final class DisableDefaultWrapperTemplateRector extends AbstractRector
{
	public function getRuleDefinition(): RuleDefinition
	{
		return new RuleDefinition('Adds a new function to all Creode_Blocks\Block classes', [
				new CodeSample(
					<<<'CODE_SAMPLE'
class MyBlock extends \Creode_Blocks\Block
{
}
CODE_SAMPLE
					,
					<<<'CODE_SAMPLE'
class MyBlock extends \Creode_Blocks\Block
{
	/**
	 * {@inheritdoc}
	 */
	protected function use_default_wrapper_template(): bool {
		return false;
	}
}
CODE_SAMPLE
				),
		]);
	}

	/**
	 * @return array<class-string<Node>>
	 */
	public function getNodeTypes(): array
	{
		return [Class_::class];
	}

	/**
	 * @param Class_ $node
	 */
	public function refactor(Node $node): ?Node
	{
		// Check if the class extends Creode_Blocks\Block
		if (!$node->extends) {
			return null;
		}

		$extendsName = $this->getName($node->extends);
		if ($extendsName !== 'Creode_Blocks\Block') {
			return null;
		}

		// Check if the method already exists
		foreach ($node->stmts as $stmt) {
			if ($stmt instanceof ClassMethod && $this->isName($stmt, 'use_default_wrapper_template')) {
				return null;
			}
		}

		// Create a new line before the new method.
		$node->stmts[] = new \PhpParser\Node\Stmt\Nop();

		// Create the new method.
		$newMethod = new ClassMethod(
			'use_default_wrapper_template',
			[
				'flags' => Node\Stmt\Class_::MODIFIER_PROTECTED,
				'returnType' => new Name('bool'),
				'stmts' => [
					new Return_(
						new \PhpParser\Node\Expr\ConstFetch(
							new \PhpParser\Node\Name('false')
						)
					),
				],
			],
		);

		$newMethod->setDocComment(
			new \PhpParser\Comment\Doc(
				<<<'DOC'
/**
 * {@inheritdoc}
 */
DOC
			)
		);

		// Add the method to the class
		$node->stmts[] = $newMethod;

		return $node;
	}
}
