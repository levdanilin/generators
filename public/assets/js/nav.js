const currentLocation = location.href;
const navItem = document.querySelectorAll('a');
const navLength = navItem.length;

for(let i = 0; i < navLength; i++)
{
    if(navItem[i].href === currentLocation)
    {
        navItem[i].classList.add('active');
    }
}