# config valid only for Capistrano 3.1

set :application, 'BiblioMania'
set :repo_url, 'git@github.com:garagepoort/BiblioMania.git'
set :tmp_dir, "/tmp"
# Default branch is :master
# ask :branch, proc { `git rev-parse --abbrev-ref HEAD`.chomp }.call

# Default deploy_to directory is /var/www/my_app
set :deploy_to, '/home/deploy/BiblioMania'

# Default value for :scm is :git
# set :scm, :git

# Default value for :format is :pretty
set :format, :pretty

# Default value for :log_level is :debug
# set :log_level, :debug

# Default value for :pty is false
set :pty, true

# Default value for :linked_files is []
# set :linked_files, %w{config/database.yml}

# Default value for linked_dirs is []
# set :linked_dirs, %w{bin log tmp/pids tmp/cache tmp/sockets vendor/bundle public/system}

# Default value for default_env is {}
# set :default_env, { path: "/opt/ruby/bin:$PATH" }

# Default value for keep_releases is 5
# set :keep_releases, 5

desc "Prompt for branch or tag"
task git_branch_or_tag: :'git:wrapper' do
  on roles(:all) do |host|

    tags = "<none>"
    within repo_path do
      with fetch(:git_environmental_variables) do
        tags = capture(:git, :tag).split.join(', ')
      end
    end

    run_locally do
      tag_prompt = "Enter a branch or tag name to deploy, available tags include #{tags}"

      ask(:branch_or_tag, tag_prompt)
      tag_branch_target = fetch(:branch_or_tag)

      execute "echo \"About to deploy branch or tag '#{tag_branch_target}'\""
      set(:branch, tag_branch_target)
    end

  end
end

before 'deploy:starting', :git_branch_or_tag

namespace :deploy do

  desc 'update composer'
  task :restart do
    on roles(:app) do
      execute "rm /home/deploy/BiblioMania/current/public/bookImages"
      execute "rm /home/deploy/BiblioMania/current/public/authorImages"
      execute "ln -s /home/deploy/BiblioMania/bookImages /home/deploy/BiblioMania/current/public/bookImages"
      execute "ln -s /home/deploy/BiblioMania/authorImages /home/deploy/BiblioMania/current/public/authorImages"
      execute "cd /home/deploy/BiblioMania/current && cp /home/deploy/BiblioMania/.env ."
      execute "cd /home/deploy/BiblioMania/current && php composer.phar update && php artisan migrate --force"
      execute :sudo, "chown -R apache:apache /home/deploy/BiblioMania/current/public"
      execute :sudo, "chown -R apache:apache /home/deploy/BiblioMania/current/storage"
      execute :sudo, "chown -R apache:apache /home/deploy/BiblioMania/current/app/storage"
    end
      # Your restart mechanism here, for example:
      # execute :touch, release_path.join('tmp/restart.txt')
  end
 
  after :publishing, :restart
end
