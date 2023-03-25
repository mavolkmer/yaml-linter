<?php

namespace MavSolutions\YamlLinter;

use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Command\LintCommand;

class YamlLinterCommand extends LintCommand
{
    protected static $defaultName = 'lint:yamlPaths';

    protected function configure(): void
    {
        parent::configure();
        $this->addOption(
            'excludePattern',
            null,
            InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
            'Pattern for path that shall be excluded'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filenames = (array)$input->getArgument('filename');
        $excludePatterns = $input->getOption('excludePattern');

        if (count($filenames) === 0) {
            throw new RuntimeException('Please provide a filename.');
        }

        foreach ($filenames as $key => $filename) {
            if (! is_dir($filename)) {
                unset($filenames[$key]);
            }
        }

        if (! empty($excludePatterns)) {
            $finder = new Finder();
            $finder->in($filenames)
                ->path($excludePatterns)
                ->ignoreDotFiles(false)
                ->ignoreVCS(true)
                ->ignoreVCSIgnored(true)
                ->name('/\.(yaml|yml)$/')
                ->files();
            $excludes = [];
            foreach ($finder as $file) {
                $excludes[] = $file->getPathname();
            }

            $excludes = array_merge($excludes, $input->getOption('exclude'));
            $input->setOption('exclude', $excludes);
        }

        return parent::execute($input, $output);
    }
}
