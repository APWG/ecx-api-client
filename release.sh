#!/usr/bin/env bash
REPO=ecx-api-client
if [ "$#" -ne 1 ]
then
  echo "you need to supply a version number string..."
  exit 1
fi
VERSION=$1
SOURCE="${BASH_SOURCE[0]}"
while [ -h "$SOURCE" ]; do
  DIR="$( cd -P "$( dirname "$SOURCE" )" && pwd )"
  SOURCE="$(readlink "$SOURCE")"
  [[ $SOURCE != /* ]] && SOURCE="$DIR/$SOURCE"
done
DIR="$( cd -P "$( dirname "$SOURCE" )" && pwd )"
echo "Updating changelog"
github-changes -o apwg -r ${REPO} -k ${GITHUB_TOKEN} -b `git branch | grep \\* | cut -d ' ' -f2` --time-zone America/Los_Angeles --date-format "(YYYY/MM/DD@HH:mm)"
git add CHANGELOG.md
git commit -m "updated changelog"
echo "Updating composer.json version"
git push https://${GITHUB_TOKEN}@github.com/apwg/${REPO}.git
sudo sed -i -E "s/(\"version\":)(\s+)(.+)/\1\2\"${VERSION}\",/" "${DIR}/composer.json"
git add composer.json
git commit -m "updated composer.json version to ${VERSION}"
git tag -a v${VERSION} -m "bump to ${VERSION}"
git push https://${GITHUB_TOKEN}@github.com/apwg/${REPO}.git
git push https://${GITHUB_TOKEN}@github.com/apwg/${REPO}.git --tags